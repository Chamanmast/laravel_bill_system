<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterviewQuestions extends Model
{
    protected $fillable = [
        'category_id',
        'user_id',
        'question',
        'answer',
        'difficulty',
        'status',
    ];
    protected $casts = [
        'status' => 'boolean',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
