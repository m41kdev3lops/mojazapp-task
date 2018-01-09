<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Item;

class myList extends Model
{
    protected $fillable = [
        'title', 'user_id'
    ];
}
