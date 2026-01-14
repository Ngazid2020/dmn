<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConsultationResource\Pages;
use App\Models\Consultation;
use App\Models\Patient;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\{
    Select,
    Textarea,
    DateTimePicker,
    Repeater,
    Hidden,
    TextInput
};
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ConsultationResource extends Resource
{
    protected static ?string $model = Consultation::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Consultations';
    protected static ?string $pluralLabel = 'Consultations';

    public static function form(Form $form): Form
    {
        return $form->schema([

            /* =========================
             * PATIENT → DOSSIER MÉDICAL
             * ========================= */
            Select::make('patient_id')
                ->label('Patient')
                ->relationship('patient', 'first_name')
                ->searchable()
                ->required()
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set) {
                    $patient = Patient::with('medicalFile')->find($state);
                    $set('medical_file_id', $patient?->medicalFile?->id);
                }),

            Hidden::make('medical_file_id')
                ->required(),

            /* =========================
             * PRATICIEN
             * ========================= */
            Select::make('user_id')
                ->label('Praticien')
                ->relationship('practitioner', 'name')
                ->searchable()
                ->required(),

            /* =========================
             * DATE CONSULTATION
             * ========================= */
            DateTimePicker::make('consulted_at')
                ->label('Date & heure de consultation')
                ->default(now())
                ->required(),

            /* =========================
             * CONTENU MÉDICAL
             * ========================= */
            Textarea::make('complaint')
                ->label('Motif / Symptômes')
                ->rows(3)
                ->required(),

            Textarea::make('diagnosis')
                ->label('Diagnostic')
                ->rows(3),

            Textarea::make('notes')
                ->label('Notes supplémentaires')
                ->rows(3),

            /* =========================
             * PRESCRIPTIONS
             * ========================= */
            Repeater::make('prescriptions')
                ->relationship()
                ->label('Prescriptions')
                ->schema([

                    Hidden::make('consultation_id'),

                    Textarea::make('notes')
                        ->label('Notes de prescription')
                        ->rows(2),

                    Repeater::make('items')
                        ->relationship()
                        ->label('Médicaments prescrits')
                        ->schema([

                            Hidden::make('prescription_id'),

                            TextInput::make('medicine')
                                ->label('Médicament')
                                ->required(),

                            TextInput::make('dosage')
                                ->label('Posologie'),

                            TextInput::make('duration')
                                ->label('Durée'),
                        ])
                        ->columns(3)
                        ->collapsible(),
                ])
                ->columns(1)
                ->collapsible(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('patient.full_name')
                    ->label('Patient')
                    ->searchable(),

                Tables\Columns\TextColumn::make('practitioner.name')
                    ->label('Praticien'),

                Tables\Columns\TextColumn::make('diagnosis')
                    ->label('Diagnostic')
                    ->limit(50)
                    ->wrap(),

                Tables\Columns\TextColumn::make('consulted_at')
                    ->label('Date')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user_id')
                    ->label('Praticien')
                    ->relationship('practitioner', 'name'),

                Tables\Filters\SelectFilter::make('patient_id')
                    ->label('Patient')
                    ->relationship('patient', 'first_name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListConsultations::route('/'),
            'create' => Pages\CreateConsultation::route('/create'),
            'edit'   => Pages\EditConsultation::route('/{record}/edit'),
        ];
    }
}
