<?php

namespace App\Filament\Resources\Types\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class TypesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('name')
                    ->label('Type Name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('parent.name')
                    ->badge()
                    ->label('Parent Type')
                    ->color(fn(string $state): string => match (strtolower($state)) {
                        'gold' => 'warning',
                        'Sliver' => 'gray',
                        'other' => 'info',
                        default => 'primary',
                    })
                    ->placeholder('— Root Type —')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                ToggleColumn::make('status')
                    ->label('Status')
                    ->offColor('success')

            ])

            ->filters([])

            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
