<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('back.categories.index', compact('categories'));
    }

    public function switch(Request $request)
    {
        $category = Category::findOrFail($request->id);
        $category->status = $request->statu == "true" ? 1 : 0;
        $category->save();
    }

    public function create(Request $request)
    {
        $isAny = Category::whereSlug(Str::slug($request->category))->first();
        if ($isAny) {
            toastr()->error('Eklemek istediğiniz kategori zaten mevcut!');
            return redirect()->back();
        }
        $category = new Category();
        $category->name = $request->category;
        $category->slug = Str::slug($request->category);
        $category->save();
        toastr()->success('Kategori başarıyla eklendi!');
        return redirect()->back();
    }

    public function getData(Request $request)
    {
        $category = Category::findOrFail($request->id);
        return response()->json($category);
    }

    public function update(Request $request)
    {
        $isAnySlug = Category::whereSlug(Str::slug($request->slug))->whereNotIn('id', [$request->category_id])->first();
        $isAnyName = Category::whereName($request->category)->whereNotIn('id', [$request->category_id])->first();
        if ($isAnySlug or $isAnyName) {
            toastr()->error('Eklemek istediğiniz kategori zaten mevcut!');
            return redirect()->back();
        }
        $category = Category::find($request->id);
        $category->name = $request->category;
        $category->slug = $request->slug;
        $category->save();
        toastr()->success('Kategori başarıyla güncellendi!');
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $category = Category::findOrFail($request->id);
        if ($category->id == 6) {
            toastr()->error('Bu kategori silinemez!');
            return redirect()->back();
        }
        $anyArticle = Article::where('category_id', $category->id)->get();

        if ($anyArticle->isNotEmpty()){
            Article::where('category_id', $category->id)->update(['category_id'=>6]);
        }
        $category->delete();

        toastr()->error('Kategori Başarıyla Silindi!');
        return redirect()->back();
    }
}
