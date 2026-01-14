<?php

namespace App\Filament\Resources\ConsultationResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class PrescriptionsRelationManager extends RelationManager
{
    protected static string $relationship = 'prescriptions';

    protected static ?string $title = 'Prescriptions';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Hidden::make('consultation_id')
                ->default(fn ($livewire) => $livewire->ownerRecord->id),

            Forms\Components\Hidden::make('patient_id')
                ->default(fn ($livewire) => $livewire->ownerRecord->patient_id),

            Forms\Components\TextInput::make('medicine_name')
                ->label('Médicament')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('dosage')
                ->label('Dosage')
                ->placeholder('Ex: 500mg'),

            Forms\Components\TextInput::make('frequency')
                ->label('Fréquence')
                ->placeholder('Ex: 2 fois / jour'),

            Forms\Components\TextInput::make('duration')
                ->label('Durée')
                ->placeholder('Ex: 7 jours'),

            Forms\Components\Textarea::make('instructions')
                ->label('Instructions')
                ->rows(3),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('medicine_name')
                    ->label('Médicament')
                    ->searchable(),

                Tables\Columns\TextColumn::make('dosage')
                    ->label('Dosage'),

                Tables\Columns\TextColumn::make('frequency')
                    ->label('Fréquence'),

                Tables\Columns\TextColumn::make('duration')
                    ->label('Durée'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
