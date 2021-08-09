<?php


namespace App\Services;


use App\Models\User;

class UserService extends Service
{
    /**
     * UserService constructor.
     * @param KindService $kindService
     * @param ColorService $colorService
     */
    public function __construct(KindService $kindService, ColorService $colorService)
    {
        $this->kindService = $kindService;
        $this->colorService = $colorService;
    }

    /**
     * 사용자 등록
     *
     * @param $request
     * @return mixed
     */
    public function createAndReturnToken($request)
    {
        $kind_id = $this->kindService->getIdByName($request->kind_type)->id;
        $color_id = $this->colorService->getIdByName($request->color_type)->id;

        $user = User::Create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'age' => $request->age,
            'type' => $request->type,
            'kind_id' => $kind_id,
            'color_id' => $color_id,
        ]);
        $token = $user->createToken('LaravelAuthApp')->accessToken;

        return $token;
    }

    /**
     * 아이디로 사용자정보 가져오기
     *
     * @param $id
     * @return mixed
     */
    public function getUserById($id)
    {
        $user = User::findOrFail($id);
        $user->kind = $user->kind()->first()->name;
        $user->color = $user->color()->first()->name;
        $jsonData = $user->toArray();
        unset($jsonData['kind_id'], $jsonData['color_id']);

        return $jsonData;
    }


}
