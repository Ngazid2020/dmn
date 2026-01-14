<?php

namespace App\Filament\Resources\MedicalFileResource\RelationManagers;

use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ConsultationsRelationManager extends RelationManager
{
    protected static string $relationship = 'consultations';

    protected static ?string $title = 'Consultations';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Hidden::make('patient_id')
                ->default(fn ($livewire) => $livewire->ownerRecord->patient_id),

            Forms\Components\Hidden::make('medical_file_id')
                ->default(fn ($livewire) => $livewire->ownerRecord->id),

            Forms\Components\Select::make('user_id')
                ->label('Praticien')
                ->options(
                    User::query()->pluck('name', 'id')
                )
                ->required(),

            Forms\Components\DateTimePicker::make('consulted_at')
                ->label('Date de consultation')
                ->default(now())
                ->required(),

            Forms\Components\Textarea::make('complaint')
                ->label('Motif / Symptômes')
                ->required()
                ->rows(3),

            Forms\Components\Textarea::make('diagnosis')
                ->label('Diagnostic')
                ->rows(3),

            Forms\Components\Textarea::make('notes')
                ->label('Notes complémentaires')
                ->rows(3),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('consulted_at')
                    ->label('Date')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('practitioner.name')
                    ->label('Praticien'),

                Tables\Columns\TextColumn::make('complaint')
                    ->label('Motif')
                    ->limit(40),

                Tables\Columns\TextColumn::make('diagnosis')
                    ->label('Diagnostic')
                    ->limit(40),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->defaultSort('consulted_at', 'desc');
    }
}
