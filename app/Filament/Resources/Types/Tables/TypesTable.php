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
                    ->label('Purity Name')
                    ->sortable()
                    ->searchable(),

                 TextColumn::make('category.name')
                    ->label('Category')
                    ->placeholder('— No Category —')
                    ->badge()
                    ->color(function ($record) {
                        if (!$record->category_id) {
                            return 'secondary'; // no category
                        }

                        return match ($record->category_id) {
                            1 => 'warning',   // Category = 1 → Yellow
                            2 => 'secondary', // Category = 2 → Gray
                            3 => 'info',      // Category = 3 → Blue
                            default => 'primary', // fallback
                        };
                    })
                    ->sortable()
                    ->searchable(),

                ToggleColumn::make('status')
                    ->label('Status')
                    ->offColor('success'),

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
