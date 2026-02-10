<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HospitalizationResource\Pages;
use App\Models\Hospitalization;
use App\Models\Patient;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\{
    Select,
    TextInput,
    Textarea,
    DatePicker,
    DateTimePicker
};
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;

class HospitalizationResource extends Resource
{
    protected static ?string $model = Hospitalization::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';
    protected static ?string $navigationLabel = 'Hospitalisations';
    protected static ?string $pluralLabel = 'Hospitalisations';
    

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Patient')
                ->schema([
                    Select::make('patient_id')
                        ->label('Patient')
                        ->options(function () {
                            $tenantId = \Filament\Facades\Filament::getTenant()?->id;
                            return Patient::where('etablissement_id', $tenantId)
                                ->orderBy('first_name')
                                ->get()
                                ->pluck('full_name', 'id');
                        })
                        ->searchable()
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set) {
                            $patient = Patient::find($state);
                            $set('medical_file_id', $patient?->medicalFile?->id);
                            $set('etablissement_id', $patient?->etablissement_id);
                        }),
                    Forms\Components\Hidden::make('medical_file_id')->required(),
                    Forms\Components\Hidden::make('etablissement_id')
                        ->default(fn () => \Filament\Facades\Filament::getTenant()?->id)
                        ->required(),
                ]),

            Forms\Components\Section::make('Hospitalisation')
                ->schema([
                    TextInput::make('service')->label('Service')->required(),
                    TextInput::make('room')->label('Chambre'),
                    TextInput::make('bed')->label('Lit'),
                    DateTimePicker::make('admitted_at')
                        ->label('Date d’admission')
                        ->required(),
                    DateTimePicker::make('discharged_at')->label('Date de sortie'),
                    Select::make('status')
                        ->label('Statut')
                        ->options([
                            'admitted' => 'Active',
                            'discharged' => 'Sortie',
                        ])
                        ->default('admitted')
                        ->required(),
                    Textarea::make('reason')->label('Motif')->rows(2),
                    Textarea::make('notes')->label('Notes supplémentaires')->rows(3),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('patient.full_name')
                    ->label('Patient')
                    ->searchable(),
                Tables\Columns\TextColumn::make('service')->label('Service')->searchable(),
                Tables\Columns\TextColumn::make('room')->label('Chambre'),
                Tables\Columns\TextColumn::make('bed')->label('Lit'),
                Tables\Columns\TextColumn::make('status')->label('Statut'),
                Tables\Columns\TextColumn::make('admitted_at')
                    ->label('Admission')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('discharged_at')
                    ->label('Sortie')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Statut')
                    ->options([
                        'active' => 'Active',
                        'discharged' => 'Sortie',
                    ]),
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
            'index'  => Pages\ListHospitalizations::route('/'),
            'create' => Pages\CreateHospitalization::route('/create'),
            'edit'   => Pages\EditHospitalization::route('/{record}/edit'),
        ];
    }
}
