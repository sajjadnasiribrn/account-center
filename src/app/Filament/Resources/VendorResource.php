<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VendorResource\Pages;
use App\Models\Vendor;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VendorResource extends Resource
{
    protected static ?string $model = Vendor::class;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Tabs::make('Translations')
                ->tabs([
                    Tab::make('FA')->schema([
                        TextInput::make('name.fa')
                            ->label('Name (FA)')
                            ->required()
                            ->maxLength(190),
                        Textarea::make('description.fa')
                            ->label('Description (FA)')
                            ->rows(4),
                    ]),
                    Tab::make('EN')->schema([
                        TextInput::make('name.en')
                            ->label('Name (EN)')
                            ->maxLength(190),
                        Textarea::make('description.en')
                            ->label('Description (EN)')
                            ->rows(4),
                    ]),
                ])
                ->columnSpanFull(),
            Select::make('user_id')
                ->relationship('user', 'name')
                ->searchable()
                ->required(),
            TextInput::make('slug')
                ->required()
                ->maxLength(190),
            Toggle::make('is_active')
                ->required(),
            TextInput::make('commission_percent')
                ->numeric()
                ->minValue(0)
                ->maxValue(100)
                ->required(),
            DateTimePicker::make('verified_at'),
            KeyValue::make('support')
                ->addable(false)
                ->deletable(false)
                ->reorderable(false)
                ->default(fn () => Vendor::defaultSupport())
                ->columnSpanFull(),
            FileUpload::make('profile_image')
                ->image()
                ->disk('public')
                ->directory('vendors/profile')
                ->visibility('public')
                ->dehydrated(false)
                ->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('profile_image')
                    ->label('Profile')
                    ->getStateUsing(fn (Vendor $record): ?string => $record->getFirstMediaUrl(Vendor::PROFILE_IMAGE_COLLECTION)),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->searchable(),
                IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('commission_percent')
                    ->sortable(),
                TextColumn::make('verified_at'),
                TextColumn::make('created_at')
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVendors::route('/'),
            'create' => Pages\CreateVendor::route('/create'),
            'edit' => Pages\EditVendor::route('/{record}/edit'),
        ];
    }
}
