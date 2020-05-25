<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Page;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $article =Article::all()->count();
        $hit=Article::sum('hit');
        $category=Category::all()->count();
        $page=Page::all()->count();

        return view('back.dashboard',compact('article','hit','category','page'));
    }
}
