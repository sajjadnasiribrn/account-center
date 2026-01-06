<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VendorResource\Pages;
use App\Models\Vendor;
use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class VendorResource extends Resource
{
    protected static ?string $model = Vendor::class;

    public static function canCreate(): bool
    {
        return true;
    }

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
                        TinyEditor::make('description.fa')
                            ->label('Description (FA)')
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsVisibility('public')
                            ->fileAttachmentsDirectory('uploads')
                            ->profile('default')
                            ->rtl()
                            ->columnSpan('full'),
                    ]),
                    Tab::make('EN')->schema([
                        TextInput::make('name.en')
                            ->label('Name (EN)')
                            ->maxLength(190),
                        TinyEditor::make('description.en')
                            ->label('Description (EN)')
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsVisibility('public')
                            ->fileAttachmentsDirectory('uploads')
                            ->profile('default')
                            ->direction('ltr')
                            ->columnSpan('full'),
                    ]),
                ])
                ->columnSpanFull(),
            Select::make('user_id')
                ->relationship('user', 'name')
                ->searchable(['name', 'email', 'phone'])
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
            KeyValue::make('support')
                ->addable(false)
                ->deletable(false)
                ->reorderable(false)
                ->default(fn () => Vendor::defaultSupport())
                ->columnSpanFull(),
            FileUpload::make('profile_image')
                ->image()
                ->disk(config('media-library.disk_name'))
                ->directory('vendors/profile')
                ->visibility('public')
                ->dehydrated(false)
                ->fetchFileInformation(false)
                ->getUploadedFileUsing(function (FileUpload $component, string $file): ?array {
                    if (Str::startsWith($file, ['http://', 'https://', 'data:'])) {
                        return [
                            'name' => basename(parse_url($file, PHP_URL_PATH) ?? $file),
                            'size' => 0,
                            'type' => null,
                            'url' => $file,
                        ];
                    }

                    $diskName = $component->getDiskName();
                    $url = $component->getDisk()->url($file);

                    if (config("filesystems.disks.{$diskName}.driver") === 'local') {
                        $parts = parse_url($url);
                        $path = $parts['path'] ?? $url;
                        $query = isset($parts['query']) ? '?' . $parts['query'] : '';
                        $url = $path . $query;
                    }

                    return [
                        'name' => basename($file),
                        'size' => 0,
                        'type' => null,
                        'url' => $url,
                    ];
                })
                ->afterStateHydrated(function (FileUpload $component, ?Vendor $record): void {
                    if (! $record) {
                        return;
                    }

                    $media = $record->getFirstMedia(Vendor::PROFILE_IMAGE_COLLECTION);

                    if (! $media) {
                        return;
                    }

                    $path = $media->getPathRelativeToRoot();

                    if (blank($path)) {
                        return;
                    }

                    $component->state([$path]);
                })
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
