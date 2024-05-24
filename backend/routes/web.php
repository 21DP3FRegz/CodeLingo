<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserCourseController;
use App\Http\Controllers\CommunityQuestionController;
use App\Http\Controllers\CommunityAnswerController;

Route::resource('courses', CourseController::class);
Route::resource('lessons', LessonController::class);
Route::resource('tests', TestController::class);
Route::resource('user_courses', UserCourseController::class);
Route::resource('community_questions', CommunityQuestionController::class);
Route::resource('community_answers', CommunityAnswerController::class);
