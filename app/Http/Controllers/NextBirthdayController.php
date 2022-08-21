<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NextBirthdayController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'birthday' => 'required|date_format:Y-m-d',
        ]);
        if ($validator->fails()) {
            return response([
                'error' => $validator->errors()->first(),
            ]);
        }
        $birthDay = $request->birthday;
        $next_birthday_createdate = Carbon::createFromDate(date('Y'), date('m', strtotime($birthDay)), date('d', strtotime($birthDay)))->format('Y-m-d');

        $nextBirthdayOfDay = floor((strtotime(date('Y-m-d H:i:s')) - strtotime($next_birthday_createdate)) / 86400);
        if ($nextBirthdayOfDay > 0) {
            $nextBirthdayOfDay = 365 - $nextBirthdayOfDay;
        } elseif ($nextBirthdayOfDay == 0) {
            $nextBirthdayOfDay = 365;
        } else {
            $nextBirthdayOfDay = abs($nextBirthdayOfDay);
        }

        $next_birthday = Carbon::now()->addDays($nextBirthdayOfDay)->format('Y-m-d H:i:s');
        $seconds = strtotime(date('Y-m-d H:i:s')) - strtotime($birthDay);
        $next_birthdayToSeconds = strtotime($next_birthday) - strtotime(date('Y-m-d'));
        $final = [
            'summary' => [
                'year' => floor($seconds / 31556926),
                'months' => floor($seconds / 2629743),
                'weeks' => floor($seconds / 604800),
                'days' => floor($seconds / 86400),
                'hours' => floor($seconds / 3600),
                'minutes' => floor($seconds / 60),
            ],
            'next_birthday' => [
                'full_date' => date('Y-m-d', strtotime($next_birthday)),
                'minutes' => floor($next_birthdayToSeconds / 60),
                'hours' =>  floor($next_birthdayToSeconds / 3600),
                'days' =>  floor($next_birthdayToSeconds / 86400),
                'weeks' => floor($next_birthdayToSeconds / 604800),
                'months' => floor($next_birthdayToSeconds / 2629743),
            ],
        ];
        return response($final);
    }
}
