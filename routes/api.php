<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);
// 질문 가져오기
Route::get('question/{id}', [QuestionController::class, 'show']);
// 질문과 답변 가져오기
Route::get('question/{id}/answer', [QuestionController::class, 'showAll']);


Route::middleware('auth:api')->group(function () {

    Route::prefix('cat')->name('cat.')->group(function () {
        // 사용자 정보 가져오기
        Route::get('{id}', [UserController::class, 'show']);
        // 사용자의 모든 질문 가져오기
        Route::get('{id}/questions', [UserController::class, 'showAllQuestions']);
        // 사용자의 모든 답변 가져오기
        Route::get('{id}/answers', [UserController::class, 'showAllAnswers']);
    });

    Route::prefix('question')->name('question.')->group(function () {
        // 질문 등록
        Route::post('', [QuestionController::class, 'create']);
        // 질문 수정
        Route::post('{id}/edit', [QuestionController::class, 'update']);
        // 질문 삭제
        Route::delete('{id}', [QuestionController::class, 'destroy']);
    });

    Route::prefix('answer')->name('answer.')->group(function () {
        // 답변 등록
        Route::post('{question_id}', [AnswerController::class, 'create']);
        // 답변 수정
        Route::post('{id}/edit', [AnswerController::class, 'update']);
        // 답변 삭제
        Route::delete('{id}', [AnswerController::class, 'destroy']);
    });
});


