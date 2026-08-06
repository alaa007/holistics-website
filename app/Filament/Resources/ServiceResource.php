<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
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

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-briefcase';

    protected static string|\UnitEnum|null $navigationGroup = 'Site Content';

    protected static ?string $navigationLabel = 'Services';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        // columns(1) keeps sections stacked full width; each section then
        // splits into 2 columns internally (English | Arabic).
        return $schema->columns(1)->components([
            Section::make('Service Details')
                ->columns(2)
                ->schema([
                    TextInput::make('slug')->required()->unique(ignoreRecord: true)->helperText('Used in the URL, e.g. home-healthcare'),
                    Select::make('icon')->options(Icons::keys())->searchable()->required(),
                    TextInput::make('order')->numeric()->default(0),
                    Toggle::make('is_active')->label('Active')->default(true),
                ]),
            Section::make('Content')
                ->columns(2)
                ->schema([
                    TextInput::make('title_en')->label('Title (English)')->required(),
                    TextInput::make('title_ar')->label('Title (Arabic)')->extraInputAttributes(['dir' => 'rtl']),
                    TextInput::make('short_en')->label('Short description (English)')->required(),
                    TextInput::make('short_ar')->label('Short description (Arabic)')->extraInputAttributes(['dir' => 'rtl']),
                    Textarea::make('overview_en')->label('Overview (English)')->required()->rows(5),
                    Textarea::make('overview_ar')->label('Overview (Arabic)')->rows(5)->extraInputAttributes(['dir' => 'rtl']),
                    Textarea::make('included_en')->label("What's included, one per line (English)")->rows(6),
                    Textarea::make('included_ar')->label("What's included, one per line (Arabic)")->rows(6)->extraInputAttributes(['dir' => 'rtl']),
                    Textarea::make('who_en')->label("Who it's for (English)")->rows(4),
                    Textarea::make('who_ar')->label("Who it's for (Arabic)")->rows(4)->extraInputAttributes(['dir' => 'rtl']),
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
                TextColumn::make('title_en')->label('Title')->searchable(),
                TextColumn::make('slug'),
                IconColumn::make('is_active')->boolean(),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
