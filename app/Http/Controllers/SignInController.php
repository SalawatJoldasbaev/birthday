<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\SignInRequest;
use Illuminate\Support\Facades\Hash;

class SignInController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\SignInRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(SignInRequest $request)
    {
        $user = User::phone($request->phone)->first();
        if (!$user or !Hash::check($request->password, $user->password)) {
            return response([
                'error' => 'phone or password is incorrect',
            ], 401);
        }
        $token = $user->createToken($request->app_name)->plainTextToken;
        return Response([
            'token' => $token,
        ]);
    }
}
