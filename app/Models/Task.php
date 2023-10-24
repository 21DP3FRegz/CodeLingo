<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'title',
        'content',
    ];

    public $timestamps = false;
    
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
