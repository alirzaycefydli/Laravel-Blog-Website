<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::orderBy('created_at', 'ASC')->get();

        return view('back.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('back.articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'min:3',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $article = new Article();
        $article->title = $request->title;
        $article->category_id = $request->category_id;
        $article->content = $request->content;
        $article->slug = Str::slug($request->title, '-');
        if ($request->hasFile('image')) {
            $random = mt_rand(1000000000, 9999999999);
            $imageName = Str::slug($request->title, '-') . $random . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'), $imageName);

            $article->image = 'uploads/' . $imageName;
        }
        $article->save();
        toastr()->success('Başarıyla kaydedildi!');
        return redirect()->route('makaleler.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return 'id= ' . $id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Article::findOrFail($id);

        $categories = Category::all();
        return view('back.articles.edit', compact('categories', 'article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'min:3',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $article = Article::findOrFail($id);
        $article->title = $request->title;
        $article->category_id = $request->category_id;
        $article->content = $request->content;
        $article->slug = Str::slug($request->title, '-');
        if ($request->hasFile('image')) {
            $random = mt_rand(1000000000, 9999999999);
            $imageName = Str::slug($request->title, '-') . $random . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'), $imageName);

            $article->image = 'uploads/' . $imageName;
        }
        $article->save();
        toastr()->success('Güncelle işlemi başarıyla gerçekleşti!');
        return redirect()->route('makaleler.index');
    }

    public function switchStatus(Request $request)
    {
        $article = Article::findOrFail($request->id);
        $article->status = $request->statu == "true" ? 1 : 0;
        $article->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    public function delete($id)
    {
        Article::find($id)->delete();
        toastr()->success('Makale silme işlemi başarıyla gerçekleşti!');
        return redirect()->route('makaleler.index');
    }

    public function trashedArticle()
    {
        $articles = Article::onlyTrashed()->orderBy('deleted_at', 'ASC')->get();

        return view('back.articles.trash', compact('articles'));
    }

    public function recoverArticle($id){
        Article::onlyTrashed()->find($id)->restore();
        return redirect()->back();
    }
    public function deleteCompletely($id)
    {
        $article =Article::onlyTrashed()->find($id);
        if (File::exists($article->image)){
            File::delete(public_path($article->image));
        }
        $article->forceDelete();
        toastr()->success('Makale silme işlemi başarıyla gerçekleşti!');
        return redirect()->route('makaleler.index');
    }
}
