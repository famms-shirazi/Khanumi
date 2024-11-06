<?php

namespace App\Http\Controllers;

use App\Models\User;
use Brick\Math\Exception\DivisionByZeroException;
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
        $user = User::find($id);
        dd($user);
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
        $user = User::find($id);
        $firstName = $request->input('first_name');
        $lastName = $request->input('last_name');
        $phoneNumber = $request->input('phone_number');
        $email = $request->input('email');
        $nationalCode = $request->input('national_code');
        $gender = $request->input('gender');
        $birthdayDate = $request->input('birthday_date');
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->phone_number = $request->input('phone_number');
        $user->email = $request->input('email');
        $user->national_code = $request->input('national_code');
        $user->gender = $request->input('gender');
        $user->birthday_date = $request->input('birthday_date');
        $user->save();
        return response()->json(['message' => 'User updated successfully.', 'user' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::destroy($id);
        dd($user);
    }

    public function getCsrfToken(){
        $csrfToken = csrf_token();
        dd($csrfToken);
    }


}
