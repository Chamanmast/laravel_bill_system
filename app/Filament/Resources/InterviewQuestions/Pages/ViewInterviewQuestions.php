<?php

namespace App\Filament\Resources\InterviewQuestions\Pages;

use App\Filament\Resources\InterviewQuestions\InterviewQuestionsResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewInterviewQuestions extends ViewRecord
{
    protected static string $resource = InterviewQuestionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
