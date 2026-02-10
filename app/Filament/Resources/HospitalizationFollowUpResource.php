<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HospitalizationFollowUpResource\Pages;
use App\Models\HospitalizationFollowUp;
use App\Models\Hospitalization;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\{
    Select,
    TextInput,
    Textarea,
    DatePicker,
    Hidden
};
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;

class HospitalizationFollowUpResource extends Resource
{
    protected static ?string $model = HospitalizationFollowUp::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';
    protected static ?string $navigationLabel = 'Suivis d’hospitalisation';
    protected static ?string $pluralLabel = 'Suivis d’hospitalisation';

    /**
     * Filament multi-tenancy : on utilise la relation "hospitalization" comme propriétaire
     */
    protected static ?string $tenantOwnershipRelationshipName = 'hospitalization';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('hospitalization_id')
                ->label('Hospitalisation')
                ->relationship('hospitalization', 'id')
                ->searchable()
                ->required()
                ->preload(),

            DatePicker::make('date')
                ->label('Date du suivi')
                ->required(),

            Textarea::make('observations')
                ->label('Observations')
                ->rows(3),

            Textarea::make('treatment')
                ->label('Traitement')
                ->rows(3),

            Textarea::make('notes')
                ->label('Notes supplémentaires')
                ->rows(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('hospitalization.id')
                    ->label('Hospitalisation'),

                Tables\Columns\TextColumn::make('date')
                    ->label('Date')
                    ->date(),

                Tables\Columns\TextColumn::make('observations')
                    ->label('Observations')
                    ->limit(50)
                    ->wrap(),

                Tables\Columns\TextColumn::make('treatment')
                    ->label('Traitement')
                    ->limit(50)
                    ->wrap(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHospitalizationFollowUps::route('/'),
            'create' => Pages\CreateHospitalizationFollowUp::route('/create'),
            'edit' => Pages\EditHospitalizationFollowUp::route('/{record}/edit'),
        ];
    }
}
