<?php

namespace App\Filament\Resources\HospitalizationFollowUpResource\Pages;

use App\Filament\Resources\HospitalizationFollowUpResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHospitalizationFollowUp extends EditRecord
{
    protected static string $resource = HospitalizationFollowUpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
