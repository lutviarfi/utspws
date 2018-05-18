<?php
namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;
use App\Http\Models\Category;

class TransCategory extends TransformerAbstract
{
  public function transform(Category $field)
  {
    // ngubah format tampilan di postman
    return [
      'id' => $field->id,
      'name' => $field->name
    ];
  }
}