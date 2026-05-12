<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\InterviewQuestions;

class InterviewQuestionSeeder extends Seeder
{
    public function run(): void
    {
        $json = File::get(database_path('data/questions.json'));
        $questions = json_decode($json, true);

        foreach ($questions as $item) {
            InterviewQuestions::create([
                'category_id' => $item['category_id'],
                'question'    => $item['question'],
                'answer'      => $item['answer'] ?? null,
                'difficulty'  => $item['difficulty'] ?? 'easy',
                'status'      => 1,
                'user_id'     => 1, // 👈 fallback user
            ]);
        }
    }
}
