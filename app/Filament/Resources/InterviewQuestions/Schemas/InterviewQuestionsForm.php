<?php

namespace App\Filament\Resources\InterviewQuestions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InterviewQuestionsForm
{
    public static function configure(Schema $schema): Schema
    {
       return $schema->components([

            Section::make('Question Details')
                ->schema([

                    Grid::make(2)
                        ->schema([
                            Select::make('category_id')
                                ->label('Category')
                                ->relationship('category', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),

                            Select::make('user_id')
                                ->label('Created By')
                                ->relationship('user', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),

                        ]),

                    Textarea::make('question')
                        ->label('Question')
                        ->rows(4)
                        ->required()
                        ->columnSpanFull(),

                    Textarea::make('answer')
                        ->label('Answer')
                        ->rows(5)
                        ->nullable()
                        ->columnSpanFull(),

                ])
                ->columnSpanFull(),

            Section::make('Additional Info')
                ->schema([

                    Grid::make(1)
                        ->schema([

                            Select::make('difficulty')
                                ->label('Difficulty')
                                ->options([
                                    'easy' => 'Easy',
                                    'medium' => 'Medium',
                                    'hard' => 'Hard',
                                ])
                                ->default('easy')
                                ->required(),


                        ]),

                ])
                ->columnSpanFull(),

        ]);
    }
}
