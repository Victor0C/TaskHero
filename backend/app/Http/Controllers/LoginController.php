<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $resquest){
        if(Auth::attempt(['email' => $resquest->email, 'password' => $resquest->password])){

            $token = $resquest->user()->createToken('api-token')->plainTextToken;


            return response()->json([
                'token' => $token
            ], 200);
        }

        return response()->json([
            'message' => 'Incorrect credentials'
        ], 401);
    }
}
