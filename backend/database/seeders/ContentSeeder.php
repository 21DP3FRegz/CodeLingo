<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Test;
use Illuminate\Support\Facades\File;

class ContentSeeder extends Seeder
{
    public function run()
    {
        $courseFiles = File::files(database_path('data'));

        foreach ($courseFiles as $file) {
            $courseData = json_decode(File::get($file->getPathname()), true);

            $course = Course::create([
                'course_name' => $courseData['course_name'],
                'description' => $courseData['description'],
                'language' => $courseData['language'],
            ]);

            foreach ($courseData['lessons'] as $index => $lessonData) {
                $lesson = Lesson::create([
                    'course_id' => $course->id,
                    'title' => $lessonData['title'],
                    'content' => $lessonData['content'],
                    'lesson_order' => $index + 1,
                ]);

                foreach ($lessonData['tests'] as $testData) {
                    Test::create([
                        'lesson_id' => $lesson->id,
                        'question' => $testData['question'],
                        'options' => $testData['options'],
                        'correct_answer' => $testData['correct_answer'],
                    ]);
                }
            }
        }
    }
}
