<?php

namespace App\Filament\Resources\HospitalizationFollowUpsResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HospitalizationResourceRelationManager extends RelationManager
{
    protected static string $relationship = 'HospitalizationResource';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('date')->required(),
                Textarea::make('observations'),
                Textarea::make('treatment'),
                Textarea::make('notes'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('followUps')
            ->columns([
                Tables\Columns\TextColumn::make('followUps'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
