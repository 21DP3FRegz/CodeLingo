<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function user_progress()
    {
        return $this->hasMany(userProgress::class);
    }
}
