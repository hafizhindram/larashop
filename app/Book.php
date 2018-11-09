<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Category;
use App\Order;

class Book extends Model
{
	use SoftDeletes;

    public function categories(){
    	return $this->belongsToMany(Category::class);
    }

    public function orders(){
    	return $this->belongsToMany(Order::class);
    }
}
