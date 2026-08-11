<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageSeoResource\Pages;
use App\Models\PageSeo;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PageSeoResource extends Resource
{
    protected static ?string $model = PageSeo::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-magnifying-glass';

    protected static string|\UnitEnum|null $navigationGroup = 'General';

    protected static ?string $navigationLabel = 'Page SEO';

    protected static ?string $modelLabel = 'Page SEO';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->columns(1)->components([
            Section::make('Page')
                ->columns(2)
                ->schema([
                    Placeholder::make('label_display')
                        ->label('Page')
                        ->content(fn (?PageSeo $record) => $record?->label ?? '—'),
                    Placeholder::make('route_name_display')
                        ->label('Route')
                        ->content(fn (?PageSeo $record) => $record?->route_name ?? '—'),
                ]),
            Section::make('Meta Tags')
                ->description(fn (?PageSeo $record) => static::usesOwnContent($record)
                    ? 'Each service page takes its title and description from the service itself — edit those under Services. The fields here are disabled because they would have no effect.'
                    : 'Leave a field blank to fall back to the site default under Site Settings. An empty Arabic field falls back to its English twin first.')
                ->columns(2)
                ->schema([
                    TextInput::make('meta_title_en')
                        ->label('Meta title (English)')
                        ->maxLength(70)
                        ->helperText('Around 60 characters shows in full on Google.')
                        ->disabled(fn (?PageSeo $record) => static::usesOwnContent($record)),
                    TextInput::make('meta_title_ar')
                        ->label('Meta title (Arabic)')
                        ->maxLength(70)
                        ->extraInputAttributes(['dir' => 'rtl'])
                        ->disabled(fn (?PageSeo $record) => static::usesOwnContent($record)),
                    Textarea::make('meta_description_en')
                        ->label('Meta description (English)')
                        ->rows(3)
                        ->maxLength(180)
                        ->helperText('Around 155 characters shows in full on Google.')
                        ->disabled(fn (?PageSeo $record) => static::usesOwnContent($record)),
                    Textarea::make('meta_description_ar')
                        ->label('Meta description (Arabic)')
                        ->rows(3)
                        ->maxLength(180)
                        ->extraInputAttributes(['dir' => 'rtl'])
                        ->disabled(fn (?PageSeo $record) => static::usesOwnContent($record)),
                ]),
            Section::make('Sharing & Indexing')
                ->columns(2)
                ->schema([
                    FileUpload::make('og_image')
                        ->label('Social share image')
                        ->image()
                        ->directory('seo')
                        ->helperText('1200×630 works best. Falls back to the site default.')
                        ->columnSpanFull(),
                    Toggle::make('noindex')
                        ->label('Hide from search engines')
                        ->helperText('Emits noindex, nofollow. Leave off for normal pages.'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('label')->label('Page')->searchable(),
                TextColumn::make('meta_title_en')->label('Title (EN)')->limit(40)->placeholder('— site default —'),
                TextColumn::make('meta_title_ar')->label('Title (AR)')->limit(40)->placeholder('— falls back to EN —'),
                IconColumn::make('noindex')->label('Hidden')->boolean(),
                TextColumn::make('updated_at')->dateTime()->sortable(),
            ])
            ->recordActions([EditAction::make()]);
    }

    /**
     * True for routes that render a single record, where the record's own
     * columns outrank anything stored here (see App\Support\Seo::resolve).
     */
    protected static function usesOwnContent(?PageSeo $record): bool
    {
        return $record?->route_name === 'services.show';
    }

    // Rows map one-to-one onto routes, so they are edited but never added or removed.
    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPageSeos::route('/'),
            'edit' => Pages\EditPageSeo::route('/{record}/edit'),
        ];
    }
}
