<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id', 'user_id', 'content',
    ];

    public function question()
    {
        return $this->belongsTo(CommunityQuestion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
