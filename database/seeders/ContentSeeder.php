<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Topic;
use App\Models\Lesson;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        $pythonTopic        = Topic::updateOrCreate(['title' => 'Python']);
        $javascriptTopic    = Topic::updateOrCreate(['title' => 'JavaScript']);
        $csharpTopic        = Topic::updateOrCreate(['title' => 'C#']);

        Lesson::factory()->count(5)->create(['topic_id' => $pythonTopic->id]);
        Lesson::factory()->count(5)->create(['topic_id' => $javascriptTopic->id]);
        Lesson::factory()->count(5)->create(['topic_id' => $csharpTopic->id]);
    }
}
