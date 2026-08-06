<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactSubmissionResource\Pages;
use App\Models\ContactSubmission;
use Filament\Actions\DeleteBulkAction;
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

class ContactSubmissionResource extends Resource
{
    protected static ?string $model = ContactSubmission::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-envelope';

    protected static string|\UnitEnum|null $navigationGroup = 'Site Content';

    protected static ?string $navigationLabel = 'Contact Inquiries';

    protected static ?int $navigationSort = 7;

    public static function form(Schema $schema): Schema
    {
        return $schema->columns(1)->components([
            Section::make('Enquiry')
                ->description('Submitted from the public contact form. Read-only.')
                ->columns(2)
                ->schema([
                    TextInput::make('name')->required()->disabled(),
                    TextInput::make('phone')->required()->disabled(),
                    TextInput::make('email')->required()->disabled(),
                    TextInput::make('service')->disabled(),
                    Textarea::make('message')->required()->disabled()->rows(6)->columnSpanFull(),
                ]),
            Section::make('Status')
                ->schema([
                    Toggle::make('is_handled')->label('Marked as handled'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('created_at')->label('Received')->dateTime()->sortable(),
                TextColumn::make('name')->searchable(),
                TextColumn::make('phone'),
                TextColumn::make('email')->searchable(),
                TextColumn::make('service'),
                IconColumn::make('is_handled')->boolean()->label('Handled'),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) ContactSubmission::where('is_handled', false)->count() ?: null;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactSubmissions::route('/'),
            'create' => Pages\CreateContactSubmission::route('/create'),
            'edit' => Pages\EditContactSubmission::route('/{record}/edit'),
        ];
    }
}
