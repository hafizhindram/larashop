<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Book;

class Category extends Model
{
    use SoftDeletes;

    public function books(){
    	return $this->belongsToMany(Book::class);
    }
}
