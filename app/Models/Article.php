<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Category;

class Article extends Model
{
    use softDeletes;

   function getCategory(){
      return $this->hasOne('App\Models\Category','id','category_id');
   }
}
