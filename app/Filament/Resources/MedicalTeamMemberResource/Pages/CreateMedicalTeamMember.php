<?php

namespace App\Filament\Resources\MedicalTeamMemberResource\Pages;

use App\Filament\Resources\MedicalTeamMemberResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMedicalTeamMember extends CreateRecord
{
    protected static string $resource = MedicalTeamMemberResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['is_leadership'] = false;

        return $data;
    }
}
