<?php

namespace App\Filament\Resources\AdminResource\Widgets;

use App\Models\Exam;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PendingExams extends BaseWidget
{
    protected static ?string $heading = 'Examens en attente';

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Exam::query()
                    ->where('status', 'requested')
                    ->with(['consultation.patient'])
            )
            ->columns([
                Tables\Columns\TextColumn::make('consultation.patient.full_name')
                    ->label('Patient')
                    ->searchable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Examen')
                    ->searchable(),

                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->badge(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Demandé le')
                    ->dateTime(),
            ])
            ->emptyStateHeading('Aucun examen en attente')
            ->defaultPaginationPageOption(5);
    }
}
