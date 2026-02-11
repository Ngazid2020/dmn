<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EtablissementResource\Pages;
use App\Filament\Resources\EtablissementResource\RelationManagers;
use App\Models\Etablissement;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class EtablissementResource extends Resource
{
    protected static ?string $model = Etablissement::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static bool $isScopedToTenant = false;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true) // met à jour quand on quitte le champ
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('slug', Str::slug($state));
                    }),
                Forms\Components\TextInput::make('slug')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\Action::make('addusers')
                        ->label('Ajouter Utilisateur')
                        ->icon('heroicon-o-plus')
                        ->form(function () {
                            return [
                                Select::make('selectedusers')
                                    ->options(User::pluck('name', 'id')->toArray())
                                    ->multiple()
                                    ->searchable()
                                    ->preload(),
                            ];
                        })
                        ->action(function (Etablissement $record, array $data) {
                            $selectedUsers = $data['selectedusers'];
                            $record->users()->syncWithoutDetaching($selectedUsers);
                        }),
                ]),
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
            'index' => Pages\ListEtablissements::route('/'),
            'create' => Pages\CreateEtablissement::route('/create'),
            'edit' => Pages\EditEtablissement::route('/{record}/edit'),
        ];
    }
}
