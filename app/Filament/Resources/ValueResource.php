<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ValueResource\Pages;
use App\Models\ValueItem;
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

class ValueResource extends Resource
{
    protected static ?string $model = ValueItem::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-sparkles';

    protected static string|\UnitEnum|null $navigationGroup = 'About Page';

    protected static ?string $navigationLabel = 'Our Values';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        // columns(1) keeps sections stacked full width; each section then
        // splits into 2 columns internally (English | Arabic).
        return $schema->columns(1)->components([
            Section::make('Content')
                ->columns(2)
                ->schema([
                    Select::make('icon')->options(Icons::keys())->searchable()->required()->columnSpanFull(),
                    TextInput::make('title_en')->label('Title (English)')->required(),
                    TextInput::make('title_ar')->label('Title (Arabic)')->extraInputAttributes(['dir' => 'rtl']),
                    Textarea::make('text_en')->label('Description (English)')->required()->rows(4),
                    Textarea::make('text_ar')->label('Description (Arabic)')->rows(4)->extraInputAttributes(['dir' => 'rtl']),
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
                TextColumn::make('icon'),
                TextColumn::make('title_en')->label('Title'),
                IconColumn::make('is_active')->boolean(),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListValues::route('/'),
            'create' => Pages\CreateValue::route('/create'),
            'edit' => Pages\EditValue::route('/{record}/edit'),
        ];
    }
}
