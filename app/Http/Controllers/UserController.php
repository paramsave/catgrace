<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $userService;

    public function __construct(Request $request, UserService $userService)
    {
        $this->userService = $userService;

//        $this->middleware('auth:api');

        if(auth()->user() !== null && auth()->user()->type === 'mentor') {
            $this->middleware('auth:api')->only(['show', 'showAllQuestions']);
        } else {
            $this->middleware('auth:api')->only(['show', 'showAllAnswers']);
        }
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
    }

}
