<?php

namespace App\Filament\Resources\users\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UsersForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('User Information')
                ->schema([

                    Grid::make(2)
                        ->schema([

                            TextInput::make('name')
                                ->label('Full Name')
                                ->required()
                                ->maxLength(255),

                            TextInput::make('username')
                                ->label('Username')
                                ->maxLength(100)
                                ->nullable(),

                        ]),

                    Grid::make(2)
                        ->schema([

                            TextInput::make('email')
                                ->label('Email Address')
                                ->email()
                                ->required()
                                ->unique(ignoreRecord: true),

                            TextInput::make('password')
                                ->label('Password')
                                ->password()
                                ->required(fn ($context) => $context === 'create')
                                ->dehydrated(fn ($state) => filled($state))
                                ->minLength(6),

                        ]),

                ])
                ->columnSpanFull(),

            Section::make('Profile & Access')
                ->schema([

                    Grid::make(2)
                        ->schema([

                            FileUpload::make('photo')
                                ->label('Profile Photo')
                                ->image()
                                ->disk('public')
                                ->directory('users')
                                ->maxSize(1024)
                                ->nullable(),

                            Select::make('role')
                                ->label('User Role')
                                ->options([
                                    'admin' => 'Admin',
                                    'user'  => 'User',
                                ])
                                ->default('user')
                                ->required(),

                        ]),

                    Toggle::make('status')
                        ->label('Active Status')
                        ->default(true),

                ])
                ->columnSpanFull(),

        ]);
    }
}
