<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PDO;

class CheckPhoneController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $user = User::phone($request->phone)->firstOrFail();
        if ($user) {
            return Response([
                'error' => 'phone is already exists',
            ], 401);
        } else {
            return Response([
                'success' => true,
            ]);
        }
    }
}
