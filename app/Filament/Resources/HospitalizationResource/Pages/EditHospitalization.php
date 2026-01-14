<?php

namespace App\Filament\Resources\HospitalizationResource\Pages;

use App\Filament\Resources\HospitalizationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHospitalization extends EditRecord
{
    protected static string $resource = HospitalizationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
