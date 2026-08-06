<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SpecialtyResource\Pages;
use App\Models\Specialty;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SpecialtyResource extends Resource
{
    protected static ?string $model = Specialty::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-tag';

    protected static string|\UnitEnum|null $navigationGroup = 'Site Content';

    protected static ?string $navigationLabel = 'Specialties';

    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return $schema->columns(1)->components([
            Section::make('Specialty')
                ->columns(2)
                ->schema([
                    TextInput::make('label_en')->label('Label (English)')->required(),
                    TextInput::make('label_ar')->label('Label (Arabic)')->extraInputAttributes(['dir' => 'rtl']),
                    TextInput::make('order')->numeric()->default(0),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('order')
            ->columns([
                TextColumn::make('order')->sortable(),
                TextColumn::make('label_en')->label('Label')->searchable(),
                TextColumn::make('team_members_count')->counts('teamMembers')->label('Team Members'),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSpecialties::route('/'),
            'create' => Pages\CreateSpecialty::route('/create'),
            'edit' => Pages\EditSpecialty::route('/{record}/edit'),
        ];
    }
}
