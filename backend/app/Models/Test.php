<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id', 'question', 'options', 'correct_answer',
    ];

    protected $casts = [
        'options' => 'array', // Ensure the options attribute is cast to an array
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
