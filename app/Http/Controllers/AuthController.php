<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginUsingPasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function usingPassword(LoginUsingPasswordRequest $request)
    {
        $data = $request->validated();
        $user = User::where('email', $data['username'])->firstOrFail();
        if (! Hash::check($data['password'], $user->password)) {
            return response()->json([
                'code'    => Response::HTTP_UNPROCESSABLE_ENTITY,
                'message' => '用户名或密码错误',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $token = $user->createToken('api-v1');

        return [
            'code'    => 0,
            'message' => 'ok',
            'data'    => [
                'access_token' => $token->plainTextToken,
            ],
        ];
    }
}
