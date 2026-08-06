<?php

namespace App\Filament\Resources\LeadershipMemberResource\Pages;

use App\Filament\Resources\LeadershipMemberResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLeadershipMember extends CreateRecord
{
    protected static string $resource = LeadershipMemberResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['is_leadership'] = true;
        $data['specialty_id'] = null;

        return $data;
    }
}
