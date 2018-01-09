<?php

namespace App\Http\Middleware;

use Closure;
use App\myList;

class CheckIfListBelongsToUser
{
    public function handle($request, Closure $next)
    {
        // Check if the list exists
        if ($list = myList::where('id', '=', $request->route()->list)->first()) {

            // Check if the list belongs to the loggedin user through a method defined in App\myList model.
            if (!$list->belongs_to_loggedin_user()) {
                return response()->json("This list doesn't belong to you :(");
            }

        // List doesn't exist so we return a friendly message.
        } else {
            return response()->json("This list wasn't found :(");
        }

        return $next($request);
    }
}
