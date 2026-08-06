<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HomeSlideResource\Pages;
use App\Models\HomeSlide;
use App\Support\Icons;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HomeSlideResource extends Resource
{
    protected static ?string $model = HomeSlide::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-photo';

    protected static string|\UnitEnum|null $navigationGroup = 'Home Page';

    protected static ?string $navigationLabel = 'Hero Slides';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        // columns(1) keeps sections stacked full width; each section then
        // splits into 2 columns internally (English | Arabic).
        return $schema->columns(1)->components([
            Section::make('Slide Content')
                ->columns(2)
                ->schema([
                    TextInput::make('eyebrow_en')->label('Eyebrow (English)')->required(),
                    TextInput::make('eyebrow_ar')->label('Eyebrow (Arabic)')->extraInputAttributes(['dir' => 'rtl']),
                    TextInput::make('heading_prefix_en')->label('Heading, plain part (English)'),
                    TextInput::make('heading_prefix_ar')->label('Heading, plain part (Arabic)')->extraInputAttributes(['dir' => 'rtl']),
                    TextInput::make('heading_highlight_en')->label('Heading, highlighted part (English)')->required(),
                    TextInput::make('heading_highlight_ar')->label('Heading, highlighted part (Arabic)')->extraInputAttributes(['dir' => 'rtl']),
                    Textarea::make('text_en')->label('Description (English)')->required()->rows(4),
                    Textarea::make('text_ar')->label('Description (Arabic)')->rows(4)->extraInputAttributes(['dir' => 'rtl']),
                ]),
            Section::make('Buttons')
                ->columns(2)
                ->schema([
                    TextInput::make('cta1_label_en')->label('Button 1 label (English)'),
                    TextInput::make('cta1_label_ar')->label('Button 1 label (Arabic)')->extraInputAttributes(['dir' => 'rtl']),
                    TextInput::make('cta2_label_en')->label('Button 2 label (English)'),
                    TextInput::make('cta2_label_ar')->label('Button 2 label (Arabic)')->extraInputAttributes(['dir' => 'rtl']),
                    TextInput::make('cta1_url')->label('Button 1 link')->placeholder('/services'),
                    TextInput::make('cta2_url')->label('Button 2 link')->placeholder('/contact'),
                ]),
            Section::make('Display')
                ->columns(2)
                ->schema([
                    TextInput::make('order')->numeric()->default(0),
                    Toggle::make('is_active')->label('Active')->default(true),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('order')
            ->columns([
                TextColumn::make('order')->sortable(),
                TextColumn::make('eyebrow_en')->label('Eyebrow')->searchable(),
                TextColumn::make('heading_highlight_en')->label('Heading'),
                IconColumn::make('is_active')->boolean(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHomeSlides::route('/'),
            'create' => Pages\CreateHomeSlide::route('/create'),
            'edit' => Pages\EditHomeSlide::route('/{record}/edit'),
        ];
    }
}
