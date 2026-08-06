<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
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
                    TextInput::make('map_query')->label('Google Maps query')->helperText('Used in the embedded map URL')->columnSpanFull(),
                ]),
            Section::make('Footer')
                ->columns(2)
                ->schema([
                    Textarea::make('footer_about_en')->label('Footer about text (English)')->rows(4),
                    Textarea::make('footer_about_ar')->label('Footer about text (Arabic)')->rows(4)->extraInputAttributes(['dir' => 'rtl']),
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
