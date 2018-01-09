<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Item;

class myList extends Model
{
    protected $fillable = [
        'title', 'user_id'
    ];

    public function belongs_to_loggedin_user()
    {
        return $this->user_id == auth()->user()->id;
    }

    public function add_item(Item $item)
    {
        $item->my_list_id = $this->id;
        $item->save();
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
