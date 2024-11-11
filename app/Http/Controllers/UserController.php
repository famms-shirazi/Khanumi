<?php

namespace App\Http\Controllers;

use App\Models\User;
use Brick\Math\Exception\DivisionByZeroException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Routing\ResponseFactory;
use Mockery\Exception;

class UserController extends Controller
{
    public function index(Request $request)
    {
        try {
            $users = User::all();
            return response()->json(['success' => true, 'data' => $users,'session'=>$request->session()->all()], 200);
        }catch (Exception $exception){
            return response()->json(['success' => false, 'message' => 'خطایی در دریافت لیست کاربران پیش آمد', 'error' => $exception->getMessage()],500);
        }
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'email' => 'required|email|unique:users_tbl,email',
            'national_code' => 'required|numeric|unique:users_tbl,national_code',
            'gender' => 'nullable|in:1,0',
            'birthday_date' => 'required|date|date_format:Y-m-d',
            'password'=> ['required', 'string', 'min:10', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*#?&]/']]);
        try {
            $user = User::create($validatedData);
            return response()->json(['success' => true, 'message' => 'کاربر با موفقیت ثبت شد.', 'data' => $user], 201);
        } catch (QueryException $e) {
            return response()->json(['success' => false, 'message' => 'خطا در ثبت کاربر.', 'error' => $e->getMessage()], 400);
        }
    }
    public function show(User $user)
    {
        try{
            $user = User::find($user);
            $response = response()->json(['success' => true, 'data' => $user], 200);
            return $response;
        }catch (ModelNotFoundException $exception){
            $response = response()->json(['success' => false, 'message' => 'کابری یافت نشد', 'error' => $exception->getMessage()]);
            return $response;
        }
    }
    public function update(Request $request,User $user)
    {
        try{
            $user = User::findOrFail($user);
        }catch (ModelNotFoundException $exception) {
            return response()->json(['success' => false, 'message' => 'کاربری یافت نشد', 'error' => $exception->getMessage()]);
        }
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'email' => 'required|email|unique:users_tbl,email',
            'national_code' => 'required|numeric|unique:users_tbl,national_code',
            'gender' => 'nullable|in:1,0',
            'birthday_date' => 'required|date|date_format:Y-m-d',
        ]);
        try {
            $user->update($request->all());
            if($user->exists()){
                return response()->json(['success' => true, 'message' => 'کاربر با موفقیت ویرایش شد',],200);
            }
        }catch (QueryException $exception){
            return response()->json(['success' => false, 'message' => 'خطایی در بروز رسانی اطلاعات کاربر پیش آمد', 'error' => $exception->getMessage()],500);
        }
    }
    public function destroy(User $user)
    {
        try {
            $deleted = User::destroy($user);
            if ($deleted) {
                return response()->json(['success' => true, 'message' => 'کاربر با موفقیت حذف شد'], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'کاربری با این شناسه یافت نشد'], 404);
            }
        } catch (QueryException $exception) {
            return response()->json(['success' => false, 'message' => 'خطایی در رابطه با حذف کاربر پیش آمد', 'error' => $exception->getMessage()], 500);
        }
    }
    public function getCsrfToken(){
        $csrfToken = csrf_token();
        dd($csrfToken);
    }
}
