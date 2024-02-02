<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_name', 'description', 'language',
    ];

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function userCourses()
    {
        return $this->hasMany(UserCourse::class);
    }

    public function questions()
    {
        return $this->hasMany(CommunityQuestion::class);
    }
}
