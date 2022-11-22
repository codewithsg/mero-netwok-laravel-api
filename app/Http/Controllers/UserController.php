<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    // creating token

    //register user or store to database
    public function store(Request $request)
    {
        // dd($request->password);
        $user = new User;
        $user->firstName = $request->firstName;
        $user->lastName = $request->lastName;
        $user->email = $request->email;
        $user->password = Hash::make($request->password, ['rounds' => 13]);

        $user->save();

        // creating token data
        // $tokenData = new class
        // {
        //     protected $fillable = [
        //         'firstName',
        //         'lastName',
        //         'email',
        //         'userId'
        //     ];
        // };

        // $tokenData->firstName = $user->firstName;
        // $tokenData->lastName = $user->lastName;
        // $tokenData->email = $user->email;
        // $tokenData->userId = $user->id;

        // $tokenData = $user->firstName + $user->lastName + $user->email + $user->id;
        $tokenData = $user->firstName . $user->lastName . $user->email . $user->id . $user->created_at;

        // hasing token
        $token = hash('sha256', $tokenData);

        // return [$user, $token];
        return ([
            'token' => $token,
            'user' => $user
        ]);


        // $user->firstName = $formField->firstname;

    }

    public function login(Request $request)
    {
        // dd($request->email);
        $user = DB::table('users')->where('email', $request->email)->first();
        if ($user == null) {
            return  response('Email address or password does not match', 403);
        }
        if (Hash::check($request->password, $user->password)) {
            // $tokenData = $user->firstName + $user->lastName + $user->email + $user->id;
            $tokenData = $user->firstName . $user->lastName . $user->email . $user->id . $user->created_at;

            // hasing token
            $token = hash('sha256', $tokenData);

            // return [$user, $token];
            return ([
                'token' => $token,
                'user' => $user
            ]);
        } else {
            return response('Email address or password does not match', 403);
        }
    }
}
