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
            // Validate list data
            $rules = [
                'title' => [
                    'bail',                  // Stop validating on the first error.
                    'required',             // the title must be present.
                    'filled',              // the title can't be empty.

                    // The same user can't have two lists with the same name BUT two different users can have a list with the same name.
                    Rule::unique('my_lists')->where(function ($query) use ($request) {
                        return $query->where([
                            ['my_lists.user_id', '=', auth()->user()->id], 
                            ['my_lists.title', '=', $request->get('title')],
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
        } elseif ($object_to_validate == 'item') {
            // validate item data
            $rules = [
                'body' => [
                    'bail',                  // Stop validating on the first error.
                    'required',             // the body must be present.
                    'filled',              // the body can't be empty.

                    // The item body must be unique in ONLY THE GIVEN LIST.
                    // The same list can't have two items with the same body BUT two different lists ( belonging to the same user as well ) CAN have the same body.
                    Rule::unique('items')->where(function ($query) use ($request) {
                        return $query->where([
                            ['items.my_list_id', '=', $request->route()->parameters()['list']],
                            ['items.body', '=', $request->get('body')],
                        ]);
                    }),
                ],
            ];

            // Custom error messages to be thrown if there is a validation error.
            $messages = [
                "required" => "The body parameter is required :(",
                "filled" => "You can't add an item with an empty body :(",
                "unique" => "You already have an item in that list with the same body :(",
            ];
        }

        $validator = Validator::make($request->all(), $rules, $messages);       // Create a validator object.

        if ($validator->fails()) {
            return response()->json($validator->messages()->first());           // Send the appropriate error message if validation fails.
        }

        return $next($request);
    }
}
