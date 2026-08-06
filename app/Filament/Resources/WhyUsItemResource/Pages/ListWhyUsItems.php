<?php

namespace App\Filament\Resources\WhyUsItemResource\Pages;

use App\Filament\Resources\WhyUsItemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWhyUsItems extends ListRecords
{
    protected static string $resource = WhyUsItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
