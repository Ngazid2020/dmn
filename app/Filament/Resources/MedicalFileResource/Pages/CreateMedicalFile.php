<?php

namespace App\Filament\Resources\MedicalFileResource\Pages;

use App\Filament\Resources\MedicalFileResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMedicalFile extends CreateRecord
{
    protected static string $resource = MedicalFileResource::class;
}
