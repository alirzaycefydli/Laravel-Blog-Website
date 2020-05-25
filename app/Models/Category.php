<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Article;

class Category extends Model
{
    public function categoryCount(){
        return $this->hasMany('app\Models\Article','category_id','id')->where('status',1)->count();
    }
}
