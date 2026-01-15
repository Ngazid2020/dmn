<?php

namespace App\Filament\Widgets;

use App\Models\Hospitalization;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ActiveHospitalizations extends BaseWidget
{
    protected static ?string $heading = 'Hospitalisations en cours';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Hospitalization::query()
                    ->where('status', 'admitted')
                    ->with('patient')
            )
            ->columns([
                Tables\Columns\TextColumn::make('patient.full_name')
                    ->label('Patient')
                    ->searchable(),

                Tables\Columns\TextColumn::make('service')
                    ->label('Service'),

                Tables\Columns\TextColumn::make('room')
                    ->label('Chambre'),

                Tables\Columns\TextColumn::make('bed')
                    ->label('Lit'),

                Tables\Columns\TextColumn::make('admitted_at')
                    ->label('Admis le')
                    ->dateTime(),
            ])
            ->emptyStateHeading('Aucune hospitalisation en cours')
            ->defaultPaginationPageOption(5);
    }
}
