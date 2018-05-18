<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;

//    public function CategoriesId()
//    {
//        return $this->hasMany('App\Http\Models\Category', 'categories_id');
//    }

    protected $fillable = [
        'title',
        'category_id',
        'publisdate',
        'author',
        'isbn',
        'publisher',
    ];

    protected $guarded = [
        'id'
    ];
}