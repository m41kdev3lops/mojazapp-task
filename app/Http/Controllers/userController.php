<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use Validator;


class userController extends Controller
{
     public function register(Request $request)
    {
        /* 
            -------------------------
             User registration logic
            -------------------------
        */

        // Data Validation.
        $validator = Validator::make($request->all(), [
            'username' => 'bail|required|unique:users,username', // the username can't be empty AND it has to be unique.
            'email' => 'bail|required|unique:users,email|email', // the email must can't be empty, has to be unique AND has to be a valid email.
            'password' => 'bail|required|min:5'                 // the password can't be empty AND has to have a minimum of 5 characters.
        ]);

        // If there's an error in the validation then stop execution and send the error as JSON.
        if ($validator->fails()) {
            return response()->json($validator->messages()->first());
        }

        // At this point the data has passed validation.

        try {
            // Create a new user object with the valid data.
            $user_object = new User([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'email' => $request->email
            ]);

            $user_object->generateToken(); // Execute the generate token method found in App\User model to generate an API token.
            $user_object->save();         // save the user object.
            return response()->json("User $user_object->username was registered successfully :) Please login now.");
        // If any exception occurred then catch it and send a friendly message.
        } catch (Exception $e) {
            return response()->json("There was an error :(");
        }
    }

    public function login(Request $request)
    {
        /* 
            -------------------------
                User login logic
            -------------------------
        */

        // validate the data
        $validator = Validator::make($request->all(), [
            'username' => 'bail|required',   // username can't be empty.
            'password' => 'bail|required'    // Password can't be empty.
        ]);

        // validation failed so we bail and send in the error message.
        if ($validator->fails()) {
            return response()->json($validator->messages()->first());
        }

        // Data is valid, let's attempt to log the user in.
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password], true)) {
            // The user credentials are valid.
            session(['api_token' => auth()->user()->api_token]);            // set the user's api token in the session.
            return response()->json("Welcome, $request->username :)");
        } else {
            // The user credentials are NOT valid.
            return response()->json("Your username/password is wrong :(");
        }
    }

    public function logout()
    {
         /* 
            -------------------------
                User logout logic
            -------------------------
        */

        // The user can't access this route unless he is logged in ( due to myAuth middleware ) so no need to validate that he is logged in again.

        session()->flush();     // remove everything in the session including api_token.
        return response()->json("You are logged out. Please come back soon :)");
    }
}
