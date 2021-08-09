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
    // 사용자 정보 가져오기
    Route::get('cat/{id}', [UserController::class, 'show']);
//    // 사용자의 모든 질문 가져오기
//    Route::get('cat/{id}/questions', [UserController::class, 'showAllQuestions']);
//    // 사용자의 모든 답변 가져오기
//    Route::get('cat/{id}/answers', [UserController::class, 'showAllAnswers']);
    // 질문 등록
    Route::post('question', [QuestionController::class, 'create']);
    // 질문 수정
    Route::post('question/{id}/edit', [QuestionController::class, 'update']);
    // 질문 삭제
    Route::delete('question/{id}', [QuestionController::class, 'destroy']);
    // 답변 등록
    Route::post('answer/{question_id}', [AnswerController::class, 'create']);
    // 답변 수정
    Route::post('answer/{id}/edit', [AnswerController::class, 'update']);
    // 답변 삭제
    Route::delete('answer/{id}', [AnswerController::class, 'destroy']);
});


