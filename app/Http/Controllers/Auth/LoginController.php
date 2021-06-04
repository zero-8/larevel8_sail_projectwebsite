<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        // public function login(Request $request)

        $time_start = microtime(true);


        if (!auth()->attempt($request->only('email', 'password'))) {
            throw new AuthenticationException();
            // throw ValidationException::withMessages([
            //     'email' => 'Invalid credentials'
            // ]);
        }

        $request->session()->regenerate();
        $time_end = microtime(true);
        $timeend = $time_end - $time_start;
        return response()->json([
            'success' => true,
            '_elapsed_time' => $timeend,
            // 'errors' => $validator->errors(),
        ], 200);
        // return response()->json(null, 201);


    }

    // public function logout(Request $request)
    // {
    //     $time_start = microtime(true);

    //     auth()->guard('web')->logout();

    //     $request->session()->invalidate();

    //     // $request->session()->regenerateToken();
    //     $time_end = microtime(true);
    //     $timeend = $time_end - $time_start;

    //     // return response()->json(null, 200);


    //     return response()->json([
    //         'success' => true,
    //         '_elapsed_time' => $timeend,
    //         // 'errors' => $validator->errors(),
    //     ], 200);
    // }
}
