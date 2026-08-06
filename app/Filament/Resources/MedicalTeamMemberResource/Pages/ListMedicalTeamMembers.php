<?php

namespace App\Filament\Resources\MedicalTeamMemberResource\Pages;

use App\Filament\Resources\MedicalTeamMemberResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMedicalTeamMembers extends ListRecords
{
    protected static string $resource = MedicalTeamMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
