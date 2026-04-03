<?php

namespace App\Filament\Resources\InterviewQuestions\Pages;

use App\Filament\Resources\InterviewQuestions\InterviewQuestionsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInterviewQuestions extends ListRecords
{
    protected static string $resource = InterviewQuestionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
