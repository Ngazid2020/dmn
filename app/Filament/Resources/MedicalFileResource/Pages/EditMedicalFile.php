<?php

namespace App\Filament\Resources\MedicalFileResource\Pages;

use App\Filament\Resources\MedicalFileResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMedicalFile extends EditRecord
{
    protected static string $resource = MedicalFileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
