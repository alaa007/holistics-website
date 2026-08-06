<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutContentResource\Pages;
use App\Models\AboutContent;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AboutContentResource extends Resource
{
    protected static ?string $model = AboutContent::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static string|\UnitEnum|null $navigationGroup = 'About Page';

    protected static ?string $navigationLabel = 'About Page Text';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        // columns(1) keeps sections stacked full width; each section then
        // splits into 2 columns internally (English | Arabic).
        return $schema->columns(1)->components([
            Section::make('Hero')
                ->description('Shown at the top of the About page.')
                ->columns(2)
                ->schema([
                    TextInput::make('hero_title_en')->label('Title (English)'),
                    TextInput::make('hero_title_ar')->label('Title (Arabic)')->extraInputAttributes(['dir' => 'rtl']),
                    Textarea::make('hero_text_en')->label('Text (English)')->rows(4),
                    Textarea::make('hero_text_ar')->label('Text (Arabic)')->rows(4)->extraInputAttributes(['dir' => 'rtl']),
                ]),
            Section::make('Who We Are')
                ->columns(2)
                ->schema([
                    Textarea::make('who_we_are_p1_en')->label('Paragraph 1 (English)')->rows(5),
                    Textarea::make('who_we_are_p1_ar')->label('Paragraph 1 (Arabic)')->rows(5)->extraInputAttributes(['dir' => 'rtl']),
                    Textarea::make('who_we_are_p2_en')->label('Paragraph 2 (English)')->rows(5),
                    Textarea::make('who_we_are_p2_ar')->label('Paragraph 2 (Arabic)')->rows(5)->extraInputAttributes(['dir' => 'rtl']),
                ]),
            Section::make('Vision & Mission')
                ->columns(2)
                ->schema([
                    Textarea::make('vision_en')->label('Vision (English)')->rows(4),
                    Textarea::make('vision_ar')->label('Vision (Arabic)')->rows(4)->extraInputAttributes(['dir' => 'rtl']),
                    Textarea::make('mission_en')->label('Mission (English)')->rows(4),
                    Textarea::make('mission_ar')->label('Mission (Arabic)')->rows(4)->extraInputAttributes(['dir' => 'rtl']),
                    Textarea::make('commitment_en')->label('Commitment (English)')->rows(4),
                    Textarea::make('commitment_ar')->label('Commitment (Arabic)')->rows(4)->extraInputAttributes(['dir' => 'rtl']),
                ]),
            Section::make('Team Section')
                ->columns(2)
                ->schema([
                    Textarea::make('team_intro_en')->label('Team intro text (English)')->rows(4),
                    Textarea::make('team_intro_ar')->label('Team intro text (Arabic)')->rows(4)->extraInputAttributes(['dir' => 'rtl']),
                    Textarea::make('advisory_note_en')->label('Medical advisory note (English)')->rows(4),
                    Textarea::make('advisory_note_ar')->label('Medical advisory note (Arabic)')->rows(4)->extraInputAttributes(['dir' => 'rtl']),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('hero_title_en')->label('Hero Title'),
                TextColumn::make('updated_at')->dateTime(),
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAboutContents::route('/'),
            'create' => Pages\CreateAboutContent::route('/create'),
            'edit' => Pages\EditAboutContent::route('/{record}/edit'),
        ];
    }
}
