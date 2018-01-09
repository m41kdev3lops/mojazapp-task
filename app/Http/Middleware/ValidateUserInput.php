<?php

namespace App\Http\Middleware;

use Closure;
use Validator;
use Illuminate\Validation\Rule;

class ValidateUserInput
{

    /*
        ---------------------------
            Validate user input
        ---------------------------
    */

    public function handle($request, Closure $next, $object_to_validate)
    {

        if ($object_to_validate == 'list') { 

            $rules = [
                'title' => [
                    'bail',                  // Stop validating on the first error.
                    'required',             // the title must be present.
                    'filled',              // the title can't be empty.

                    // The title has to be unique to each other.
                    // The same user can't have two lists with the same name BUT two different users can have a list with the same name.
                    Rule::unique('my_lists')->where(function ($query) use ($request) {
                        return $query->where([
                            ['my_lists.user_id', '=', auth()->user()->id], 
                            ['my_lists.title', '=', $request->query('title')],
                        ]);
                    }),
                ],
            ];

            // Custom error messages to be thrown if there is a validation error.
            $messages = [
                "required" => "The title parameter is required :(",
                "filled" => "You can't add a list with an empty title :(",
                "unique" => "You already have a list with the same title :(",
            ];
        } 

        $validator = Validator::make($request->all(), $rules, $messages);       // Create a validator object.

        if ($validator->fails()) {
            return response()->json($validator->messages()->first());           // Send the appropriate error message if validation fails.
        }

        return $next($request);
    }
}
