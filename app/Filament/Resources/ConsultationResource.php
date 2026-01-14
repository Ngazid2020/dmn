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
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
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
                })
                ->preload(),

            Hidden::make('medical_file_id')
                ->required(),

            /* =========================
             * PRATICIEN
             * ========================= */
            Select::make('user_id')
                ->label('Praticien')
                ->relationship('practitioner', 'name')
                ->searchable()
                ->required()
                ->preload(),

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
            Repeater::make('exams')
                ->relationship()
                ->label('Examens demandés')
                ->schema([

                    Select::make('type')
                        ->label('Type')
                        ->options([
                            'biologie' => 'Biologie',
                            'imagerie' => 'Imagerie',
                            'autre' => 'Autre',
                        ])
                        ->required(),

                    TextInput::make('name')
                        ->label('Nom de l’examen')
                        ->required(),

                    Textarea::make('notes')
                        ->label('Notes'),

                    Select::make('status')
                        ->label('Statut')
                        ->options([
                            'requested' => 'Demandé',
                            'received' => 'Résultat reçu',
                        ])
                        ->default('requested'),

                    Repeater::make('results')
                        ->relationship()
                        ->label('Résultats')
                        ->schema([

                            Textarea::make('result')
                                ->label('Résultat'),

                            Forms\Components\FileUpload::make('file')
                                ->label('Fichier')
                                ->directory('exam-results')
                                ->openable()
                                ->downloadable(),

                            Forms\Components\DatePicker::make('result_date')
                                ->label('Date du résultat'),
                        ])
                        ->collapsible(),
                ])
                ->collapsible()

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
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Action::make('ordonnance')
                        ->label('Ordonnance PDF')
                        ->icon('heroicon-o-document-arrow-down')
                        ->color(Color::Amber)
                        ->url(function ($record) {
                            $prescription = $record->prescriptions()->first();

                            return $prescription
                                ? route('prescriptions.pdf', $prescription->id)
                                : null;
                        })
                        ->openUrlInNewTab()
                        ->visible(fn($record) => $record->prescriptions()->exists()),
                ]),
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
