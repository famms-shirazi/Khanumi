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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     */
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
        ]);
        try {
            $user = User::create($validatedData);
            return response()->json([
                'success' => true,
                'message' => 'کاربر با موفقیت ثبت شد.',
                'data' => $user
            ], 201);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در ثبت کاربر.',
                'error' => $e->getMessage()
            ], 400);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try{
            $user = User::findorFail($id);
            $response = response()->json([
                'success' => true,
                'data' => $user
            ], 200);
            return $response;
        }catch (ModelNotFoundException $exception){
            $response = response()->json([
                'success' => false,
                'message' => 'کابری یافت نشد',
                'error' => $exception->getMessage()
            ],404);
            return $response;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,int $id)
    {
        try{
            $user = User::findOrFail($id);
        }catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'کاربری یافت نشد',
                'error' => $exception->getMessage()
            ]);
        }
        try {
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->phone_number = $request->input('phone_number');
            $user->email = $request->input('email');
            $user->national_code = $request->input('national_code');
            $user->gender = $request->input('gender');
            $user->birthday_date = $request->input('birthday_date');
            $user->save();
            if($user->exists()){
                return response()->json([
                    'success' => true,
                    'message' => 'کاربر با موفقیت ویرایش شد',
                ],200);
            }
        }catch (QueryException $exception){
            return response()->json([
                'success' => false,
                'message' => 'خطایی در بروز رسانی اطلاعات کاربر پیش آمد',
                'error' => $exception->getMessage()
            ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $deleted = User::destroy($id);
            if ($deleted) {
                return response()->json([
                    'success' => true,
                    'message' => 'کاربر با موفقیت حذف شد'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'کاربری با این شناسه یافت نشد'
                ], 404);
            }
        } catch (QueryException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'خطایی در رابطه با حذف کاربر پیش آمد',
                'error' => $exception->getMessage()
            ], 500);
        }
    }


    public function getCsrfToken(){
        $csrfToken = csrf_token();
        dd($csrfToken);
    }


}
