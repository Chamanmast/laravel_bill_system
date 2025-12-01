<?php

namespace App\Filament\Resources\Purities\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use App\Models\Type;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class PuritiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('name')
                    ->label('Purity Name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('type.name')
                    ->label('Type')
                    ->placeholder('— No Type —')
                    ->sortable()
                    ->searchable(),

                ToggleColumn::make('status')
                    ->label('Status')
                    ->offColor('success')

            ])

            ->filters([
                SelectFilter::make('type_id')
                    ->label('Filter by Type')
                    ->options(
                        Type::query()
                            ->where('status', 0)
                            ->whereNull('parent_id')
                            ->pluck('name', 'id')
                    )
                    ->searchable()
                    ->placeholder('All Types'),
            ])

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
