<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('name')
                ->required()
                ->maxLength(190),
            TextInput::make('email')
                ->email()
                ->unique(ignoreRecord: true)
                ->maxLength(190),
            TextInput::make('phone')
                ->tel()
                ->unique(ignoreRecord: true)
                ->maxLength(20),
            TextInput::make('google_id')
                ->unique(ignoreRecord: true)
                ->maxLength(190),
            TextInput::make('password')
                ->password()
                ->required(fn (?User $record) => $record === null)
                ->dehydrated(fn (?string $state) => filled($state))
                ->maxLength(190),
            Toggle::make('is_admin')
                ->default(false)
                ->required(),
            DateTimePicker::make('email_verified_at'),
            DateTimePicker::make('phone_verified_at'),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->searchable(),
                IconColumn::make('is_admin')
                    ->boolean(),
                TextColumn::make('email_verified_at'),
                TextColumn::make('phone_verified_at'),
                TextColumn::make('created_at')
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
