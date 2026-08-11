<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ContactSubmissionResource;
use App\Models\ContactSubmission;
use Filament\Actions\Action;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestContactSubmissions extends BaseWidget
{
    private const LIMIT = 10;

    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Latest Contact Inquiries')
            ->description('The '.self::LIMIT.' most recent enquiries from the website contact form. Older ones are under Contact Inquiries.')
            // Genuinely the latest ten, not a paginated view of everything:
            // the full list lives under Contact Inquiries.
            ->query(fn () => ContactSubmission::query()->latest()->limit(self::LIMIT))
            ->paginated(false)
            ->columns([
                TextColumn::make('created_at')
                    ->label('Received')
                    ->dateTime('d M Y, H:i')
                    ->since()
                    ->tooltip(fn (ContactSubmission $record) => $record->created_at?->format('d M Y, H:i'))
                    ->sortable(),
                TextColumn::make('name')->searchable(),
                TextColumn::make('phone')->copyable(),
                TextColumn::make('email')->searchable()->copyable(),
                TextColumn::make('service')->placeholder('General inquiry'),
                TextColumn::make('message')->limit(60)->wrap()->tooltip(fn (ContactSubmission $record) => $record->message),
                IconColumn::make('is_handled')->label('Handled')->boolean(),
            ])
            ->recordActions([
                Action::make('open')
                    ->label('Open')
                    ->icon('heroicon-m-arrow-top-right-on-square')
                    ->url(fn (ContactSubmission $record) => ContactSubmissionResource::getUrl('edit', ['record' => $record])),
            ])
            ->emptyStateHeading('No inquiries yet')
            ->emptyStateDescription('Submissions from the website contact form will appear here.')
            ->emptyStateIcon('heroicon-o-inbox');
    }
}
