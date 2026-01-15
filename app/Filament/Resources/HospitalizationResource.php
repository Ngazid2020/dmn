<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HospitalizationResource\Pages;
use App\Filament\Resources\HospitalizationResource\RelationManagers;
use App\Models\Hospitalization;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HospitalizationResource extends Resource
{
    protected static ?string $model = Hospitalization::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([

            Select::make('patient_id')
                ->relationship('patient', 'first_name')
                ->searchable()
                ->required()
                ->reactive()
                ->afterStateUpdated(
                    fn($state, $set) =>
                    $set(
                        'medical_file_id',
                        \App\Models\Patient::find($state)?->medicalFile?->id
                    )
                )
                ->preload(),

            Hidden::make('medical_file_id')->required(),

            TextInput::make('service')->label('Service'),
            TextInput::make('room')->label('Chambre'),
            TextInput::make('bed')->label('Lit'),

            DateTimePicker::make('admitted_at')
                ->label('Date admission')
                ->default(now())
                ->required(),

            DateTimePicker::make('discharged_at')
                ->label('Date sortie'),

            Select::make('status')
                ->options([
                    'admitted' => 'Hospitalisé',
                    'discharged' => 'Sorti',
                ])
                ->required(),

            Textarea::make('reason')->label('Motif'),
            Textarea::make('notes')->label('Notes'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('patient.full_name')->label('Patient')->searchable(),
                TextColumn::make('service')->label('Service'),
                TextColumn::make('status')->badge(),
                TextColumn::make('admitted_at')->dateTime(),
                TextColumn::make('discharged_at')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListHospitalizations::route('/'),
            'create' => Pages\CreateHospitalization::route('/create'),
            'edit' => Pages\EditHospitalization::route('/{record}/edit'),
        ];
    }
}
