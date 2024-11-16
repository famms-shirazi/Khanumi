<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Configuration\Exceptions;
class AuthController extends Controller
{
    private const API_KEY = '616A316D546A316E4A6A7757435A67486F4D41746448594B326977306F6F43596453517832662B565169493D';
    private const template = 'verify';
    private function otpGenerator(String $phoneNumber){
        try{
            $data = ['template' => self::template, 'receptor' => $phoneNumber, 'token' => str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT)];
            $response = Http::withOptions(['verify'=>false])->post('https://api.kavenegar.com/v1/' . self::API_KEY . '/verify/lookup.json', $data);
            if($response->successful()) return $response->json();
            return $response->json(['success' => false, 'message' => 'ارسال کد OTP با خطا مواجه شد', 'error' => $response->body()], 500);
        }catch (Exception $exception){
            return response()->json(['success' => false, 'message' => 'ارسال کد otp با خطا مواجه شد', 'exception' => $exception->getMessage()], 500);
        }
    }
    private function otpVerificator(String $generatedOtp, String $enteredOtp):bool{
        if($enteredOtp == $generatedOtp) return true;
        return false;
    }
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

              $otpGeneratedCode = $this->otpGenerator($input);
              $enteredOtp = $request->input('otp-entered');
              $otpGeneratedCode = "3323";
              $otpValidationStatus = $this->otpVerificator($otpGeneratedCode,$enteredOtp);
              $userExistence = User::where('phone_number', $input)->exists();
              // فعلا اینجا این مقدار را برابر با true قرار دادم اما بعدا که مشکلات مربوط به پنل پیامکی برطرف شد این مشکل را برطرف میکنم
              if($otpValidationStatus){
                  if($userExistence){
                      try{
                          $user = User::where('phone_number', $input)->first();
                          Auth::login($user);
                          Session::put('user-id', $user->id);
                          Session::put('auth-id', Auth::id().str_pad(random_int(0, 999999),4));
                          return response()->json(['success' => true, 'message' => 'کاربر با موفقیت وارد شد', 'user' => Auth::user()], 201);
                      }catch (Exception $exception){
                          return response()->json(['success' => false, 'message' => 'ورود کاربر با خطا مواجه شد', 'exception' => $exception->getMessage()], 500);
                      }
                  }else{
                      $user = new User();
                      $user->phone_number = $input;
                      try{
                          $user->save();
                          Auth::login($user);
                          Session::put('user-id', $user->id);
                          Session::put('auth-id', Auth::id());
                          return response()->json(['success' => true, 'message' => 'کاربر با موفقیت وارد شد', 'user' => Auth::user()], 201);
                      }catch (Exception $exception){
                          return response()->json(['success' => false, 'message' => 'ورود کاربر با خطا مواجه شد', 'exception' => $exception->getMessage()], 500);
                      }
                  }
              }else{
                  return response()->json(['success' => false, 'message' => 'کد تایید وارد شده اشتباه است'], 401);
              }
        }
    }
    public function logOut(Request $request):JsonResponse{
        Auth::logout();
        if(!Auth::check()) return response()->json(['success'=>true,'message'=>'کاربر با موفقیت خارج شد'],200);
    }
}
