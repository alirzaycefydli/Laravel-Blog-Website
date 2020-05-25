<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Page;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /*
     * HomeController de çalışan tüm fonksiyonlarda geçerli method
     */
    public function __construct(){
        if (Settings::find(1)->status ==0){
            //it means website is offline
            return redirect()->to('offline')->send();
        }
        view()->share('pages',Page::where('status',1)->orderBy('order','ASC')->get());
        view()->share('categories',Category::where('status',1)->inRandomOrder()->get());
    }

    public function index(){
        $data['articles']=Article::with('getCategory')->where('status',1)->whereHas('getCategory',function($query){
            $query->where('status',1);
        })->orderBy('created_at','DESC')->paginate(5);
        return view('front.home',$data);
    }

    public function details($category,$slug){
        $category= Category::whereSlug($category)->first() ?? abort(404,'Böyle bir kategori bulunamadı!');
        $article =Article::where('status',1)->where('slug',$slug)->whereCategoryId($category->id)->first() ?? abort(404,'Böyle bir yazı bulunamadı!');
        $article->increment('hit');
        $data['articles']=$article;
        return view('front.detail',$data);
    }

    public function category($slug){
        $category= Category::whereSlug($slug)->first() ?? abort(404,'Böyle bir kategori bulunamadı!');
        $data['category']=$category;
        $data['articles']=Article::where('status',1)->where('category_id',$category->id)->orderBy('created_at','DESC')->paginate(2);
        return view('front.category',$data);
    }

    public function page($slug){

        $page = Page::whereSlug($slug)->first() ?? abort(403,'Böyle bir sayfa bulunamadı.');
        $data['page'] = $page;
        return view('front.page',$data);
    }

    public function contact(){
        return view('front.contact');
    }

    public function contactpost(Request $request){

        $rules=[
            'name'=>'required|min:5',
            'email' => 'required|email',
            'topic' => 'required',
            'message' => 'required|min:20'
        ];

       $validate= Validator::make($request->post(),$rules);

       if ($validate->fails()){
           return redirect()->route('contact')->withErrors($validate)->withInput();
       }
        /*$contact = new Contact();
        $contact->name=$request->name;
        $contact->email=$request->email;
        $contact->topic=$request->topic;
        $contact->message=$request->message;
        $contact->save();*/

        Mail::raw('Bu bir deneme mailidir...',function ($message) use ($request){
            $message->from('iletisim@myblog.com','MyBlog');
            $message->to('kalimate90@gmail.com');
            $message->subject($request->name.' kişisinden mesaj var');
        });
        return redirect()->route('contact')->with('success','Mesajınız başarıyla gönderildi!');
    }
}
