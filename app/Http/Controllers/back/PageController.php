<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('order','ASC')->get();
        return view('back.pages.index', compact('pages'));
    }

    public function switchPage(Request $request)
    {
        $page = Page::findOrFail($request->id);
        $page->status = $request->statu == "true" ? 1 : 0;
        $page->save();
    }

    public function create(){
        return view('back.pages.create');
    }

    public function post(Request $request){

        $request->validate([
            'title' => 'min:3',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $lastOrder=Page::orderBy('order','DESC')->first();
        $page = new Page();
        $page->title = $request->title;
        $page->order=$lastOrder->order+1;
        $page->content = $request->content;
        $page->slug = Str::slug($request->title, '-');
        if ($request->hasFile('image')) {
            $random = mt_rand(1000000000, 9999999999);
            $imageName = Str::slug($request->title, '-') . $random . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'), $imageName);

            $page->image = 'uploads/' . $imageName;
        }
        $page->save();
        toastr()->success('Başarıyla kaydedildi!');
        return redirect()->route('pages');
    }

    public function edit($id){
        $page=Page::findOrFail($id);
        return view('back.pages.edit',compact('page'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'min:3',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $page = Page::findOrFail($id);
        $page->title = $request->title;
        $page->content = $request->content;
        $page->slug = Str::slug($request->title, '-');
        if ($request->hasFile('image')) {
            $random = mt_rand(1000000000, 9999999999);
            $imageName = Str::slug($request->title, '-') . $random . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'), $imageName);

            $page->image = 'uploads/' . $imageName;
        }
        $page->save();
        toastr()->success('Güncelleme işlemi başarıyla gerçekleşti!');
        return redirect()->route('pages');
    }
    public function delete($id)
    {
        $page =Page::findOrFail($id);
        if (File::exists($page->image)){
            File::delete(public_path($page->image));
        }
        $page->delete();
        toastr()->success('Sayfa silme işlemi başarıyla gerçekleşti!');
        return redirect()->route('pages');
    }

    public function orders(Request $request){
        foreach ($request->get('page') as $key => $order){
            Page::where('id',$order)->update(['order'=>$key]);
        }
    }

}
