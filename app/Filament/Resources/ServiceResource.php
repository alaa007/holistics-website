<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use App\Support\Icons;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\FileUpload;
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
use Filament\Tables\Columns\ViewColumn;
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
                    Select::make('icon')->options(Icons::selectOptions())->allowHtml()->native(false)->searchable()->required(),
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
            Section::make('SEO')
                ->description('Optional. Leave blank to use the service title and short description.')
                ->collapsed()
                ->columns(2)
                ->schema([
                    TextInput::make('meta_title_en')->label('Meta title (English)')->maxLength(70)->placeholder('Defaults to the title above'),
                    TextInput::make('meta_title_ar')->label('Meta title (Arabic)')->maxLength(70)->placeholder('Defaults to the title above')->extraInputAttributes(['dir' => 'rtl']),
                    Textarea::make('meta_description_en')->label('Meta description (English)')->rows(3)->maxLength(180)->placeholder('Defaults to the short description above'),
                    Textarea::make('meta_description_ar')->label('Meta description (Arabic)')->rows(3)->maxLength(180)->placeholder('Defaults to the short description above')->extraInputAttributes(['dir' => 'rtl']),
                    FileUpload::make('og_image')->label('Social share image')->image()->directory('seo')->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('order')
            ->columns([
                TextColumn::make('order')->sortable(),
                ViewColumn::make('icon')->view('filament.tables.columns.icon-preview'),
                TextColumn::make('title_en')->label('Title')->searchable(),
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
