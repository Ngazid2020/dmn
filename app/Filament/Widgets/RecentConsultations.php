<?php

namespace App\Filament\Widgets;

use App\Models\Consultation;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentConsultations extends BaseWidget
{
    protected static ?string $heading = 'Consultations récentes';

    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Consultation::query()
                    ->with(['patient', 'practitioner'])
                    ->latest('consulted_at')
            )
            ->columns([
                Tables\Columns\TextColumn::make('patient.full_name')
                    ->label('Patient')
                    ->searchable(),

                Tables\Columns\TextColumn::make('practitioner.name')
                    ->label('Médecin'),

                Tables\Columns\TextColumn::make('consulted_at')
                    ->label('Date')
                    ->dateTime(),
            ])
            ->defaultPaginationPageOption(5)
            ->emptyStateHeading('Aucune consultation récente');
    }
}
