<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    const API_KEY = '616A316D546A316E4A6A7757435A67486F4D41746448594B326977306F6F43596453517832662B565169493D';
    const template = 'verify';
    public function login(Request $request){
        $input = $request->input();
        $field = filter_var($request->input, FILTER_VALIDATE_EMAIL) ? 'email'
            : (preg_match('/^09\d{9}$/', $request->input) ? 'phone_number'
            : 'username');
        if ($field == 'email' || $field == 'username') {
            $credentials = [$field => $request->input, 'password' => $request->password];
                $auth_status = Auth::attempt($credentials);
                if ($auth_status) {
                    Session::put('session_id', Auth::id());
                    Session::put('email', Auth::user()->email);
                    return response()->json(['success' => true, 'message' => 'کاربر با موفقیت وارد شد', 'user' => Auth::user()], 201);
                }
                return response()->json(['success' => false, 'message' => 'ورود کاربر با خطا مواجه شد'], 401);
        }else {
            $data = ['template' => self::template, 'receptor' => '09133173757', 'token' => rand(100000, 999999), 'sender'=>'2000500666'];
            $response = Http::withOptions([
            ])->post('https://api.kavenegar.com/v1/' . self::API_KEY . '/verify/lookup.json', $data);
            if ($response->successful()) {
                Session::put('session_id', Auth::id());
                Session::put('email', Auth::user()->email);
                return response()->json(['success' => true, 'message' => 'کاربر با موفقیت وارد شد', 'user' => Auth::user()], 201);
            }
            return response()->json(['success' => false, 'message' => 'ورود کاربر با خطا مواجه شد','data'=>$response->body()], 401);
        }
    }
    public function logOut(Request $request){
        Auth::logout();
        if(!Auth::check()) return response()->json(['success'=>true,'message'=>'کاربر با موفقیت خارج شد'],200);
    }
}
