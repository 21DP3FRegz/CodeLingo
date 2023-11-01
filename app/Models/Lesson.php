<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function user_progress()
    {
        return $this->hasMany(userProgress::class);
    }
}
