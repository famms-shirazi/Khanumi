<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Configuration\Exceptions;
class AuthController extends Controller
{
    const API_KEY = '616A316D546A316E4A6A7757435A67486F4D41746448594B326977306F6F43596453517832662B565169493D';
    const template = 'verify';
    public function login(Request $request):JsonResponse{
        $input = $request->input('input');
        $field = filter_var($request->input('input'), FILTER_VALIDATE_EMAIL) ? 'email'
            : (preg_match('/^09\d{9}$/', $request->input('input')) ? 'phone_number'
            : 'username');
        if ($field == 'email' || $field == 'username') {
            $credentials = [$field => $request->input('input'), 'password' => $request->password];
                try{
                    $auth_status = Auth::attempt($credentials);
                    if ($auth_status) {
                        Session::put('session_id', Auth::id());
                        Session::put('email', Auth::user()->email);
                        return response()->json(['success' => true, 'message' => 'کاربر با موفقیت وارد شد', 'user' => Auth::user()], 201);
                    }else{
                        return response()->json(['success' => false, 'message' => 'اطلاعات ورود اشتباه است'], 401);
                    }
                }catch (Exception $exception){
                        return response()->json(['success' => false, 'message' => 'ورود کاربر با خطا مواجه شد', 'exception' => $exception->getMessage()], 500);
                }
        }else {
            $data = ['template' => self::template, 'receptor' => 'input', 'token' => rand(100000, 999999)];
//            $response = Http::withOptions(['verify'=>false])->post('https://api.kavenegar.com/v1/' . self::API_KEY . '/verify/lookup.json', $data);
              Session::put('phone-number', $data['receptor']);
              Session::put('otp', 1256);
              // فعلا اینجا این مقدار را برابر با true قرار دادم اما بعدا که مشکلات مربوط به پنل پیامکی برطرف شد این مشکل را برطرف میکنم
              $response = true;
            if ($response) {
                $otp_entered = $request->input('otp-entered');
                if ($otp_entered !== Session::get('otp')) return response()->json(['success' => false, 'message' => 'کد تایید اشتباه است'], 401);
                    $user = User::where('phone_number', $input)->first();
                    if(!$user) return response()->json(['success' => false, 'message' => 'اطلاعات ورود اشتباه است'], 401);
                        $remembrance = $request->has('remembrance');
                        try{
                            Auth::login($user,$remembrance);
                            Session::put('session_id', Auth::id());
                            Session::put('email', Auth::user()->email);
                        }catch (Exception $exception){
                            return response()->json(['success' => false, 'message' => 'ورود کاربر با خطا مواجه شد', 'exception' => $exception->getMessage()], 500);
                        }
                        return response()->json(['success' => true, 'message' => 'کاربر با موفقیت وارد شد', 'user' => Auth::user()], 201);
            }
            return response()->json(['success' => false, 'message' => 'ورود کاربر با خطا مواجه شد'], 401);
        }
    }
    public function logOut(Request $request):JsonResponse{
        Auth::logout();
        if(!Auth::check()) return response()->json(['success'=>true,'message'=>'کاربر با موفقیت خارج شد'],200);
    }
}
