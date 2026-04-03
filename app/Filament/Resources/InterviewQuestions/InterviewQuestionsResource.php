<?php
namespace App\Filament\Resources\InterviewQuestions;

use App\Filament\Resources\InterviewQuestions\Pages\CreateInterviewQuestions;
use App\Filament\Resources\InterviewQuestions\Pages\EditInterviewQuestions;
use App\Filament\Resources\InterviewQuestions\Pages\ListInterviewQuestions;
use App\Filament\Resources\InterviewQuestions\Pages\ViewInterviewQuestions;
use App\Filament\Resources\InterviewQuestions\Schemas\InterviewQuestionsForm;
use App\Filament\Resources\InterviewQuestions\Schemas\InterviewQuestionsInfolist;
use App\Filament\Resources\InterviewQuestions\Tables\InterviewQuestionsTable;
use App\Models\InterviewQuestions;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class InterviewQuestionsResource extends Resource
{
    protected static ?string $model = InterviewQuestions::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute             = 'InterviewQuestions';
    protected static string|UnitEnum|null $navigationGroup = 'Menu';

    protected static ?int $navigationSort = 3;
    public static function form(Schema $schema): Schema
    {
        return InterviewQuestionsForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InterviewQuestionsInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InterviewQuestionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListInterviewQuestions::route('/'),
            'create' => CreateInterviewQuestions::route('/create'),
            'view'   => ViewInterviewQuestions::route('/{record}'),
            'edit'   => EditInterviewQuestions::route('/{record}/edit'),
        ];
    }
}
