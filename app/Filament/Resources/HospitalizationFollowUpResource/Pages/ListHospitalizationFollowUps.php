<?php

namespace App\Filament\Resources\HospitalizationFollowUpResource\Pages;

use App\Filament\Resources\HospitalizationFollowUpResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHospitalizationFollowUps extends ListRecords
{
    protected static string $resource = HospitalizationFollowUpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
