<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MedicalFileResource\Pages;
use App\Filament\Resources\MedicalFileResource\RelationManagers\ConsultationsRelationManager;
use App\Models\MedicalFile;
use App\Models\Patient;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MedicalFileResource extends Resource
{
    protected static ?string $model = MedicalFile::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder-open';
    protected static ?string $navigationLabel = 'Dossiers médicaux';
    protected static ?string $pluralLabel = 'Dossiers médicaux';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Patient')
                ->schema([
                    Forms\Components\Select::make('patient_id')
                        ->label('Patient')
                        ->options(
                            Patient::query()
                                ->orderBy('first_name')
                                ->get()
                                ->pluck('full_name', 'id')
                        )
                        ->searchable()
                        ->required()
                        ->unique(ignoreRecord: true),
                ]),

            Forms\Components\Section::make('Dossier médical')
                ->schema([
                    Forms\Components\TextInput::make('reference')
                        ->label('Référence')
                        ->disabled()
                        ->dehydrated()
                        ->placeholder('Générée automatiquement'),

                    Forms\Components\Textarea::make('notes')
                        ->label('Notes générales')
                        ->rows(5),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('reference')
                    ->label('Référence')
                    ->searchable(),

                Tables\Columns\TextColumn::make('patient.full_name')
                    ->label('Patient')
                    ->searchable(),

                Tables\Columns\TextColumn::make('consultations_count')
                    ->label('Consultations')
                    ->counts('consultations'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('pdf')
                    ->label('PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->url(fn($record) => route('medical-files.pdf', $record))
                    ->openUrlInNewTab()
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ConsultationsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMedicalFiles::route('/'),
            'create' => Pages\CreateMedicalFile::route('/create'),
            'edit' => Pages\EditMedicalFile::route('/{record}/edit'),
        ];
    }
}
