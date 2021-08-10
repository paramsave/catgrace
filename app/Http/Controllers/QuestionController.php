<?php

namespace App\Http\Controllers;

use App\Services\AnswerService;
use App\Services\QuestionService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class QuestionController extends Controller
{
    protected $questionService, $answerService;

    /**
     * 게시글 생성/수정시 룰 지정
     *
     * @var string[]
     */
    protected $createRules = [
        'type' => 'required',
        'title' => 'required|string|max:255',
        'content' => 'required|string',
    ];

    public function __construct(QuestionService $questionService, AnswerService $answerService)
    {
        $this->questionService = $questionService;
        $this->answerService = $answerService;
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $question = $this->questionService->getQuestionWithUser($id);
        $question->content = substr($question->content, 0, 20);

        return response()->json(['success' => true, 'data' => $question]);
    }

    /**
     * 질문과 답변 함께 보기
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showAll($id)
    {
        $question = $this->questionService->getQuestionWithUser($id);
        $answers = $question->answers;
        $answers = $this->answerService->getAnswersWithUser($answers);

        return response()->json(['success' => true,
            'data' => [
                'question' => $question,
            ]
        ]);
    }

    /**
     * 사용자의 모든 질문 보기
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showAllQuestions($id)
    {
        $questions = $this->questionService->getAllQuestionsByUserId($id);

        return response()->json(['success' => true, 'data' => $questions]);
    }

    /**
     * 게시글 생성
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request)
    {
        try {
            $this->validate($request, $this->createRules);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'data' => 'create validation error.']);
        }

        $question = $this->questionService->create($request);

        return response()->json(['success' => true, 'data' => $question->all()->toArray()]);
    }

    /**
     * 게시글 수정
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $this->validate($request, $this->createRules);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'data' => 'update validation error.']);
        }

        $this->questionService->update($request, $id);

        return response()->json(['success' => true]);
    }

    /**
     * 질문 삭제하기
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->questionService->delete($id);

        return response()->json(['success' => true]);
    }

}
