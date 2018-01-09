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

    public function view($list)
    {
        /* 
            -----------------------
               View a specific list
            -----------------------
        */

        // After confirming the user is logged in (through myAuth middleware)...
        // Return a list object in JSON format after confirming that the list belongs to the user (through CheckIfListBelongsToUser middleware).
        // if the list doesn't exist then return a friendly message
        return myList::where('id', '=', $list)->with('items')->first();
    }

    public function destroy($list)
    {
         /* 
            -----------------------
                Delete a list
            -----------------------
        */

        try {
            // Checking if the list exists happens in the CheckIfListBelongsToUser middleware.

            $list = myList::where('id', '=', $list)->first(); // fetch the list object with id equals the passed in id after confirming the list belongs to the loggedin user.
            $list->items()->delete();   // delete the items that are associated with the list ( the items which have my_list_id column equals the list id passed in).
            $list->delete();           // delete the list itself.

            return response()->json("The list with its items have been deleted :)");
        } catch (Exception $e) {
            // In case of any exceptions, catch them and return a friendly message instead.
            return response()->json("There was an error :(");
        }
    }

    public function edit(Request $request, $list)
    {
        /* 
            -----------------------
                Edit a list
            -----------------------
        */

        // Checking if the list exists happens in the CheckIfListBelongsToUser middleware.
        $list = myList::where('id', '=', $list)->first();
        try {
            $list->title = $request->title;         // Set the list title to the passed in title after validating it in ValidateUserInput middleware
            $list->save();                          // save the list object
            return response()->json('List edited successfully :)');
        } catch (Exception $e) {
            // In case of any exceptions, catch them and return a friendly message instead.
            return response()->json("There was an error :(");
        }
    }
}
