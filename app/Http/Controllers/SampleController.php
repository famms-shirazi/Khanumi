<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\User;

class SampleController extends Controller
{
    public function csrfToken():void{
        $csrfToken = csrf_token();
        dd($csrfToken);
    }
    public function delete():void{
        $user = User::truncate();
        dd('the user deleted successfully');
    }

    public function createUser(Request $request){
          $firstName = $request->input('first_name');
          $lastName = $request->input('last_name');
          $phoneNumber = $request->input('phone_number');
          $email = $request->input('email');
          $nationalCode = $request->input('national_code');
          $gender = $request->input('gender');
          $birthdayDate = $request->input('birthday_date');
          $user = User::create([
              'first_name'=>$firstName,
              'last_name'=>$lastName,
              'phone_number'=>$phoneNumber,
              'email'=>$email,
              'national_code'=>$nationalCode,
              'gender'=>$gender,
              'birthday_date'=>$birthdayDate
          ]);
          if($user->exists) $message = "user created successfully !"."id :".$user->id;
          dd($message);

    }

    public function showAll(){
        $users = User::all();
        dd($users);
    }
}
