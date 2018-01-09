<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\myList;
use Validator;

class listController extends Controller
{
    public function list_all()
    {
        /* 
            -----------------------
                View all lists
            -----------------------
        */

        // Verifing that the user is logged in through myAuth middleware.

        $all_lists = myList::where('user_id', '=', auth()->user()->id)->get();      // select all lists that has a user_id equals the authorized user id

        if (count($all_lists)) {
            return response()->json($all_lists);                                    // return all lists if the results are not empty
        } else {
            return response()->json("You don't have any Lists yet :(");             // No lists found
        }
    }

    public function store(Request $request)
    {
        /* 
            -----------------------
               Create a new list
            -----------------------
        */

        // Verifing that the user is logged in through myAuth middleware.
        // Data is being validataed through valideUserInput middleware.


        try {
            // Create a new list object using the valid data.
            $list = new myList([
                'title' => $request->title,
                'user_id' => auth()->user()->id,
            ]);

            $list->save();          // Save the list object
            return response()->json("List created successfully :)");

        // Any exceptions thrown will be caught and a friendly message is sent instead.
        } catch (Exception $e) {
            return response()->json("There was an error :(");
        }
    }
}
