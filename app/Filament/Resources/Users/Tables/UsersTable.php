<?php
namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),

                ImageColumn::make('photo')
                    ->label('Photo')
                    ->circular()
                    ->defaultImageUrl(url('/assets/u.png')),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('username')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('email')
                    ->label('Email Address')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('role')
                    ->badge()
                    ->colors([
                        'danger'  => 'admin',
                        'success' => 'user',
                    ])
                    ->sortable(),

                ToggleColumn::make('status')
                    ->label('Status')
                    ->offColor('success'),

                TextColumn::make('email_verified_at')
                    ->label('Verified At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([

                SelectFilter::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'user'  => 'User',
                    ]),

                TernaryFilter::make('status')
                    ->label('Active Status'),

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
