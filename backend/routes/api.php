<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);


use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\TestController;

Route::resource('courses', CourseController::class);
Route::resource('lessons', LessonController::class);
Route::resource('tests', TestController::class);


use App\Http\Controllers\UserCourseController;
use App\Http\Controllers\CommunityQuestionController;
use App\Http\Controllers\CommunityAnswerController;

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('user_courses', UserCourseController::class)->except(['create', 'edit']);
    Route::resource('questions', CommunityQuestionController::class)->except(['create', 'edit']);
    Route::resource('answers', CommunityAnswerController::class)->except(['create', 'edit']);
});
