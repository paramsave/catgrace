<?php

namespace App\Http\Controllers;

use App\Services\ColorService;
use App\Services\KindService;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Models\User;

class PassportAuthController extends Controller
{
    protected $userService;

    public function __construct(Request $request, UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Registration
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'age' => 'required|integer|digits_between:1,15',
            'type' => 'required|string',
            'kind_type' => 'required|string',
            'color_type' => 'required|string',
        ]);

        $token = $this->userService->createAndReturnToken($request);

        return response()->json(['token' => $token], 200);
    }

    /**
     * Login
     * * @param Request $request
     * * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $data = ['email' => $request->email, 'password' => $request->password];
        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
}
