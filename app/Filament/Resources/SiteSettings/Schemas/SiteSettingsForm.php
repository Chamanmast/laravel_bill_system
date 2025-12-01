<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class SiteSettingsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Branding')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            FileUpload::make('logo')
                                ->label('Upload Logo')
                                ->disk('public')
                                ->directory('uploads')
                                ->preserveFilenames()
                                ->maxSize(1024)
                                ->acceptedFileTypes(['application/pdf', 'image/*'])
                                ->nullable(),

                            FileUpload::make('favicon')
                                ->label('Upload Favicon')
                                ->disk('public')
                                ->directory('uploads')
                                ->preserveFilenames()
                                ->maxSize(1024)
                                ->acceptedFileTypes(['application/pdf', 'image/*'])
                                ->nullable(),
                        ]),
                ])
                ->columnSpanFull(),


            Section::make('General Settings')
                ->schema([
                    Grid::make(2)
                        ->schema([
                    TextInput::make('site_title')
                        ->label('Site Title')
                        ->maxLength(100)
                        ->required(),

                    TextInput::make('app_name')
                        ->label('App Name')
                        ->maxLength(100)
                        ->nullable(),

                        ]),
                        Textarea::make('address')
                        ->label('Address')
                        ->nullable(),
                    Grid::make(2)
                        ->schema([
                            TextInput::make('about')
                                ->label('About')
                                ->maxLength(400),

                            TextInput::make('phone')
                                ->label('Phone')
                                ->maxLength(50)
                                ->nullable(),

                            TextInput::make('email')
                                ->label('Email')
                                ->maxLength(50)
                                ->nullable(),



                        ]),
                ])
                ->columnSpanFull(),


        ]);
    }
}
