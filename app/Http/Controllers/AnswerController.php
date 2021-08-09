<?php

namespace App\Http\Controllers;

use App\Services\AnswerService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AnswerController extends controller
{
    protected $answerService;

    protected $createRules = [
        'content' => 'required|string',
        'choose' => 'required',
    ];

    public function __construct(AnswerService $answerService)
    {
        $this->answerService = $answerService;
    }

    /**
     * 덧글 작성
     *
     * @param Request $request
     * @param $question_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request, $question_id)
    {
        try {
            $this->validate($request, $this->createRules);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'data' => 'create validation error.']);
        }

        $answer = $this->answerService->create($request, $question_id);

        return response()->json(['success' => true, 'data' => $answer]);
    }

    /**
     * 덧글 수정
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $this->validate($request, $this->createRules);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'data' => 'update validation error.']);
        }

        $this->answerService->update($request, $id);

        return response()->json(['success' => true]);

    }

    /**
     * 답변 삭제하기
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->answerService->delete($id);

        return response()->json(['success' => true]);
    }


}
