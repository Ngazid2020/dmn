<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\{
    Select,
    DateTimePicker,
    Textarea
};
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationLabel = 'Rendez-vous';
    protected static ?string $pluralLabel = 'Rendez-vous';

    public static function form(Form $form): Form
    {
        return $form->schema([

            /* =========================
             * PATIENT
             * ========================= */
            Select::make('patient_id')
                ->label('Patient')
                ->relationship('patient', 'first_name')
                ->searchable()
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
             * DATE & HEURE
             * ========================= */
            DateTimePicker::make('scheduled_at')
                ->label('Date & Heure')
                ->required(),

            /* =========================
             * MOTIF / RAISON
             * ========================= */
            Textarea::make('reason')
                ->label('Motif du rendez-vous')
                ->rows(3),

            /* =========================
             * STATUT
             * ========================= */
            Select::make('status')
                ->label('Statut')
                ->options([
                    'pending' => 'En attente',
                    'confirmed' => 'Confirmé',
                    'cancelled' => 'Annulé',
                ])
                ->default('pending')
                ->required(),
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
                    ->label('Praticien')
                    ->searchable(),

                Tables\Columns\TextColumn::make('scheduled_at')
                    ->label('Date & Heure')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Statut')
                    ->formatStateUsing(function ($state) {
                        return match ($state) {
                            'pending' => 'En attente',
                            'confirmed' => 'Confirmé',
                            'cancelled' => 'Annulé',
                            default => $state,
                        };
                    })
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Statut')
                    ->options([
                        'pending' => 'En attente',
                        'confirmed' => 'Confirmé',
                        'cancelled' => 'Annulé',
                    ]),

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
            'index'  => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit'   => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
