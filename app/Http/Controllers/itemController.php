<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\myList;

class itemController extends Controller
{

    public function view($list, $item)
    {
        /* 
            ------------------------------
                View a specific item
            ------------------------------
        */

        // Return the item object in JSON format ONLY IF the item exists AND it belongs to the same list that was passed in the query.
        // This ensures to trigger CheckIfListBelongsToUser which checks if the current list belongs to the current loggedin user.
        // More simply, the user can't view the item UNLESS it belongs to a list which belongs to the loggedin user.
        // Otherwise, a friendly message is returned.
        return Item::where('id', '=', $item)->where('my_list_id', '=', $list)->first() ?? response()->json("This item wasn't found in that list :(");
    }

    public function store($list, Request $request)
    {
        /* 
            ------------------------------
                    Create an item
            ------------------------------
        */

        // Create a new item object with the valid data ( validated in ValidateUserInput middleware)...
        // AFTER CHECKING that the list belongs to the loggedin user ( through the CheckIfListBelongsToUser middleware ).
        $item_object = new Item();
        $list = myList::where('id', '=', $list)->first();

        try {
            $item_object->body = $request->body;        // Set the item object body param to the body passed in the request query.
            $list->add_item($item_object);              // execute a method called add_item on the parent list which adds the list id to the my_list_id field on the item.
            $item_object->save();                              // Save the item object.
            return response()->json("Item added successfully to `$list->title` :)");
        } catch (Exception $e) {
            return response()->json("There was an error :(");
        }
    }

    public function edit($list, $item, Request $request)
    {
        /* 
            ------------------------------
                Edit a specific item
            ------------------------------
        */

        if ($item = Item::where('id', '=', $item)->where('my_list_id', '=', $list)->first()){

            try {
                $item->body = $request->body;
                $item->save();
                return response()->json("Item updated successfully :)");
            } catch (Exception $e) {
                return response()->json("There was an error :(");
            }

        } else {
            return response()->json("That item wasn't found :(");
        }
    }

    public function destroy($list, $item)
    {
        /* 
            ------------------------------
                Delete a specific item
            ------------------------------
        */

        // Check if the item is found AND it belongs to the list.
        if (!$item = Item::where('id', '=', $item)->where('my_list_id', '=', $list)->first()) {
            return response()->json("That item wasn't found in that list :(");
        }

        // Check if the item's parent list belongs to the loggedin user.
        if ($item->belongs_to_loggedin_user()) {
            try {
                $item->delete();
                return response()->json("Item deleted successfully :)");
            } catch (Exception $e) {
                return response()->json("There was an error :(");
            }
        } else {
            return response()->json("The list that this item belongs to isn't yours :(");
        }
    }
}
