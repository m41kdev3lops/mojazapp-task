<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\myList;

class Item extends Model
{
    public function list()
    {
        return $this->belongsTo(myList::class, 'my_list_id');
    }

    public function belongs_to_loggedin_user()
    {
        return $this->list->user_id == auth()->user()->id;
    }
}
