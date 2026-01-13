<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatientResource\Pages;
use App\Filament\Resources\PatientResource\RelationManagers;
use App\Models\Patient;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Patients';
    protected static ?string $pluralLabel = 'Patients';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Identité')
                ->schema([
                    Grid::make(2)->schema([
                        Forms\Components\TextInput::make('first_name')
                            ->label('Prénom')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('last_name')
                            ->label('Nom')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('gender')
                            ->label('Sexe')
                            ->options([
                                'male' => 'Homme',
                                'female' => 'Femme',
                            ])
                            ->required(),

                        Forms\Components\DatePicker::make('date_of_birth')
                            ->label('Date de naissance')
                            ->required(),
                    ]),
                ]),

            Section::make('Coordonnées')
                ->schema([
                    Forms\Components\TextInput::make('phone')
                        ->label('Téléphone')
                        ->tel(),

                    Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->unique(ignoreRecord: true),

                    Forms\Components\Textarea::make('address')
                        ->label('Adresse'),
                ]),

            Section::make('Informations médicales')
                ->schema([
                    Forms\Components\Select::make('blood_group')
                        ->label('Groupe sanguin')
                        ->options([
                            'A+' => 'A+',
                            'A-' => 'A-',
                            'B+' => 'B+',
                            'B-' => 'B-',
                            'AB+' => 'AB+',
                            'AB-' => 'AB-',
                            'O+' => 'O+',
                            'O-' => 'O-',
                        ]),

                    Forms\Components\Textarea::make('allergies')
                        ->label('Allergies connues'),

                    Forms\Components\Textarea::make('medical_history')
                        ->label('Antécédents médicaux'),
                ]),

            Section::make('Contact d’urgence')
                ->schema([
                    Forms\Components\TextInput::make('emergency_contact')
                        ->label('Contact d’urgence'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Patient')
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(),

                Tables\Columns\TextColumn::make('gender')
                    ->label('Sexe'),

                Tables\Columns\TextColumn::make('blood_group')
                    ->label('Groupe sanguin'),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Téléphone'),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('gender')
                    ->options([
                        'male' => 'Homme',
                        'female' => 'Femme',
                    ]),

                Tables\Filters\SelectFilter::make('blood_group')
                    ->options([
                        'A+' => 'A+',
                        'A-' => 'A-',
                        'B+' => 'B+',
                        'B-' => 'B-',
                        'AB+' => 'AB+',
                        'AB-' => 'AB-',
                        'O+' => 'O+',
                        'O-' => 'O-',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }
}
