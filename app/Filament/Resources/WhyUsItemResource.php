<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WhyUsItemResource\Pages;
use App\Models\WhyUsItem;
use App\Support\Icons;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
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

class WhyUsItemResource extends Resource
{
    protected static ?string $model = WhyUsItem::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-check-badge';

    protected static string|\UnitEnum|null $navigationGroup = 'Home Page';

    protected static ?string $navigationLabel = 'Why Choose Us';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        // columns(1) keeps sections stacked full width; each section then
        // splits into 2 columns internally (English | Arabic).
        return $schema->columns(1)->components([
            Section::make('Content')
                ->columns(2)
                ->schema([
                    Select::make('icon')->options(Icons::keys())->searchable()->required()->columnSpanFull(),
                    TextInput::make('text_en')->label('Text (English)')->required(),
                    TextInput::make('text_ar')->label('Text (Arabic)')->extraInputAttributes(['dir' => 'rtl']),
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
                TextColumn::make('text_en')->label('Text')->limit(50),
                IconColumn::make('is_active')->boolean(),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWhyUsItems::route('/'),
            'create' => Pages\CreateWhyUsItem::route('/create'),
            'edit' => Pages\EditWhyUsItem::route('/{record}/edit'),
        ];
    }
}
