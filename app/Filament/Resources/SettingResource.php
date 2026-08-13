<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string|\UnitEnum|null $navigationGroup = 'General';

    protected static ?string $navigationLabel = 'Site Settings';

    protected static ?int $navigationSort = 0;

    public static function form(Schema $schema): Schema
    {
        // columns(1) keeps sections stacked full width; each section then
        // splits into 2 columns internally (English | Arabic).
        return $schema->columns(1)->components([
            Section::make('Brand')
                ->columns(2)
                ->schema([
                    TextInput::make('brand_name')->label('Brand name')->required()->columnSpanFull(),
                    TextInput::make('tagline_en')->label('Tagline (English)')->required(),
                    TextInput::make('tagline_ar')->label('Tagline (Arabic)')->extraInputAttributes(['dir' => 'rtl']),
                ]),
            Section::make('Contact Details')
                ->columns(2)
                ->schema([
                    TextInput::make('whatsapp_number')->label('WhatsApp number')->helperText('Digits only with country code, e.g. 962781818211')->required(),
                    TextInput::make('phone_display')->label('Phone (display)')->required(),
                    TextInput::make('phone_href')->label('Phone link')->helperText('e.g. tel:+962781818211')->required(),
                    TextInput::make('email')->label('Email')->email()->required(),
                ]),
            Section::make('Address & Map')
                ->columns(2)
                ->schema([
                    TextInput::make('address_en')->label('Address (English)')->required(),
                    TextInput::make('address_ar')->label('Address (Arabic)')->extraInputAttributes(['dir' => 'rtl']),
                    TextInput::make('map_query')->label('Google Maps query')->helperText('Legacy fallback, no longer shown on the site')->columnSpanFull(),
                    Textarea::make('map_embed_src')->label('Google Maps embed URL')->helperText('Google Maps → Share → Embed a map → Copy HTML, then paste just the iframe\'s src="..." value here')->rows(3)->columnSpanFull(),
                ]),
            Section::make('Footer')
                ->columns(2)
                ->schema([
                    Textarea::make('footer_about_en')->label('Footer about text (English)')->rows(4),
                    Textarea::make('footer_about_ar')->label('Footer about text (Arabic)')->rows(4)->extraInputAttributes(['dir' => 'rtl']),
                ]),
            Section::make('Default SEO')
                ->description('Used for any page that has no SEO of its own. Per-page overrides live under Page SEO.')
                ->columns(2)
                ->schema([
                    TextInput::make('seo_title_suffix_en')
                        ->label('Title suffix (English)')
                        ->helperText('Appended to page titles as "Page — Suffix". Skipped when the title already contains it.'),
                    TextInput::make('seo_title_suffix_ar')
                        ->label('Title suffix (Arabic)')
                        ->extraInputAttributes(['dir' => 'rtl']),
                    TextInput::make('seo_title_en')->label('Default meta title (English)')->maxLength(70),
                    TextInput::make('seo_title_ar')->label('Default meta title (Arabic)')->maxLength(70)->extraInputAttributes(['dir' => 'rtl']),
                    Textarea::make('seo_description_en')->label('Default meta description (English)')->rows(3)->maxLength(180),
                    Textarea::make('seo_description_ar')->label('Default meta description (Arabic)')->rows(3)->maxLength(180)->extraInputAttributes(['dir' => 'rtl']),
                    FileUpload::make('og_image')
                        ->label('Default social share image')
                        ->image()
                        ->directory('seo')
                        ->helperText('Shown when a page is shared on social media. 1200×630 works best.')
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('brand_name'),
                TextColumn::make('email'),
                TextColumn::make('phone_display'),
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
