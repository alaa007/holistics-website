<?php

namespace App\Filament\Resources\MedicalTeamMemberResource\Pages;

use App\Filament\Resources\MedicalTeamMemberResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMedicalTeamMember extends EditRecord
{
    protected static string $resource = MedicalTeamMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['is_leadership'] = false;

        return $data;
    }
}
