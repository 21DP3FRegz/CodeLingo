<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Topic;
use App\Models\Lesson;
use App\Models\Task;
use App\Models\UserProgress;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $user = User::updateOrCreate([
                'email' => 'user@example.com',
                'name' => 'user',
                'password' => '$2y$10$sle.82qcGEFdsHuS86sQC.gjgyVG.iFhTnuuC6X2KD4IJI367Jhfm',
            ]
        );
    }
}