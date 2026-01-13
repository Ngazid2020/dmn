<?php
namespace App\Filament\Resources;

use App\Filament\Resources\ConsultationResource\Pages;
use App\Models\Consultation;
use App\Models\Patient;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;

class ConsultationResource extends Resource
{
    protected static ?string $model = Consultation::class;
    protected static ?string $navigationIcon = 'heroicon-o-document';
    protected static ?string $navigationLabel = 'Consultations';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('medical_file_id')
                ->label('Dossier Médical')
                ->options(function () {
                    return Patient::with('medicalFile')->get()
                        ->filter(fn($p) => $p->medicalFile)
                        ->pluck('medicalFile.reference', 'medicalFile.id');
                })
                ->searchable()
                ->required(),

            Select::make('patient_id')
                ->label('Patient')
                ->options(Patient::all()->pluck('first_name', 'id'))
                ->searchable()
                ->required(),

            Select::make('user_id')
                ->label('Praticien')
                ->options(User::all()->pluck('name', 'id'))
                ->searchable()
                ->required(),

            DateTimePicker::make('consulted_at')
                ->label('Date & heure')
                ->default(now())
                ->required(),

            Textarea::make('complaint')
                ->label('Motif / Symptômes')
                ->required()
                ->rows(3),

            Textarea::make('diagnosis')
                ->label('Diagnostic')
                ->rows(3),

            Textarea::make('notes')
                ->label('Notes supplémentaires')
                ->rows(3),

            // 🔹 Gestion des prescriptions directement dans la consultation
            Repeater::make('prescriptions')
                ->relationship('prescriptions')
                ->label('Prescriptions')
                ->schema([
                    Textarea::make('notes')->label('Notes de prescription')->rows(2),

                    Repeater::make('items')
                        ->relationship('items')
                        ->label('Médicaments')
                        ->schema([
                            Forms\Components\TextInput::make('medicine')->required()->label('Médicament'),
                            Forms\Components\TextInput::make('dosage')->label('Posologie'),
                            Forms\Components\TextInput::make('duration')->label('Durée'),
                        ])
                        ->columns(3),
                ])
                ->columns(1),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('patient.first_name')->label('Patient'),
            Tables\Columns\TextColumn::make('practitioner.name')->label('Praticien'),
            Tables\Columns\TextColumn::make('diagnosis')->label('Diagnostic')->limit(30),
            Tables\Columns\TextColumn::make('consulted_at')->dateTime()->label('Date'),
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
            'index' => Pages\ListConsultations::route('/'),
            'create' => Pages\CreateConsultation::route('/create'),
            'edit' => Pages\EditConsultation::route('/{record}/edit'),
        ];
    }
}