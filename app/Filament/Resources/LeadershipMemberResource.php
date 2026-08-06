<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeamMemberResource\Pages;
use App\Models\TeamMember;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\FileUpload;
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
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TeamMemberResource extends Resource
{
    protected static ?string $model = TeamMember::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user-group';

    protected static string|\UnitEnum|null $navigationGroup = 'Site Content';

    protected static ?string $navigationLabel = 'Medical Team';

    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        // columns(1) keeps sections stacked full width; each section then
        // splits into 2 columns internally (English | Arabic).
        return $schema->columns(1)->components([
            Section::make('Profile')
                ->columns(2)
                ->schema([
                    TextInput::make('name')->helperText('Leave blank for a "Profile Coming Soon" placeholder card'),
                    TextInput::make('credentials')->placeholder('MBA, RN, PT...'),
                    TextInput::make('specialty')->required()->helperText('Slug used for filtering, e.g. nursing'),
                    // Kept at half width: full width blows the image preview
                    // panel up into a mostly-empty block.
                    //
                    // Stored as a square 400x400 thumbnail rather than the
                    // original upload: avatars render at 96px, so shipping
                    // full-resolution photos to visitors is wasted bytes.
                    // "cover" crops to fill, matching the CSS object-fit.
                    FileUpload::make('photo')
                        ->image()
                        ->directory('team')
                        ->visibility('public')
                        ->imageEditor()
                        ->imageCropAspectRatio('1:1')
                        ->imageResizeMode('cover')
                        ->imageResizeTargetWidth('400')
                        ->imageResizeTargetHeight('400'),
                ]),
            Section::make('Content')
                ->columns(2)
                ->schema([
                    TextInput::make('role_en')->label('Role / Title (English)')->required(),
                    TextInput::make('role_ar')->label('Role / Title (Arabic)')->extraInputAttributes(['dir' => 'rtl']),
                    TextInput::make('specialty_label_en')->label('Specialty label (English)')->required(),
                    TextInput::make('specialty_label_ar')->label('Specialty label (Arabic)')->extraInputAttributes(['dir' => 'rtl']),
                    Textarea::make('bio_en')->label('Bio (English)')->required()->rows(5),
                    Textarea::make('bio_ar')->label('Bio (Arabic)')->rows(5)->extraInputAttributes(['dir' => 'rtl']),
                ]),
            Section::make('Display')
                ->columns(2)
                ->schema([
                    Toggle::make('is_leadership')->label('Leadership team (About page)')->default(false),
                    Toggle::make('is_placeholder')->label('Placeholder profile')->default(true),
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
                ImageColumn::make('photo')->circular(),
                TextColumn::make('name')->searchable()->placeholder('— placeholder —'),
                TextColumn::make('role_en')->label('Role'),
                TextColumn::make('specialty_label_en')->label('Specialty'),
                IconColumn::make('is_leadership')->boolean()->label('Leadership'),
                IconColumn::make('is_active')->boolean(),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTeamMembers::route('/'),
            'create' => Pages\CreateTeamMember::route('/create'),
            'edit' => Pages\EditTeamMember::route('/{record}/edit'),
        ];
    }
}
