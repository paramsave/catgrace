<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AnswerService;
use App\Services\QuestionService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $userService, $questionService, $answerService;

    public function __construct(Request $request, UserService $userService, QuestionService $questionService, AnswerService $answerService)
    {
        $this->userService = $userService;
        $this->questionService = $questionService;
        $this->answerService = $answerService;
    }

    /**
     * 고양이 정보 보기
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $jsonData = $this->userService->getUserById($id);

        return response()->json(['success' => true, 'data' => $jsonData ], 200);
    }

    /**
     * 해당 고양이의 모든 질문 보기
     *
     * @param $id
     */
    public function showAllQuestions($id)
    {
        $questions = $this->questionService->getAllQuestionsByUserId($id);

        return response()->json(['success' => true, 'data' => $questions ], 200);
    }

    /**
     * 해당 고양이의 모든 답변 보기
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showAllAnswers($id)
    {
        $answers = $this->answerService->getAnswersByUserId($id);

        return response()->json(['success' => true, 'data' => $answers ], 200);
    }

}
