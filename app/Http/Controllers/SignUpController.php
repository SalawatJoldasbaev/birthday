<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignUpRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SignUpController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\SignUpRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(SignUpRequest $request)
    {
        $user = User::phone($request->phone)->first();
        if ($user) {
            return Response([
                'error' => 'phone is already exists',
            ], 401);
        }
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'username' => $request->username,
            'telegram_id' => $request->telegram_id,
            'password' => Hash::make($request->password),
            'birthday' => $request->birthday,
        ]);
        $token = $user->createToken($request->app_name)->plainTextToken;
        return Response([
            'token' => $token,
        ]);
    }
}
