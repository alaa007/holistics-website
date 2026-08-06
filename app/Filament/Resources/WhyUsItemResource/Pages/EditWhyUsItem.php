<?php

namespace App\Filament\Resources\WhyUsItemResource\Pages;

use App\Filament\Resources\WhyUsItemResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditWhyUsItem extends EditRecord
{
    protected static string $resource = WhyUsItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
