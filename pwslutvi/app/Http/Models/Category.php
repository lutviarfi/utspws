<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
  use SoftDeletes;

  protected $fillable = [
    'name',
  ];

  protected $guarded = ['id'];
  public function category(){
    return $this->hasMany('App\Http\Models\Book','id');
  }
}