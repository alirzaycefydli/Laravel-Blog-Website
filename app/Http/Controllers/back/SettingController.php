<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    public function index(){
        $settings=Settings::find(1);
        return view('back.settings.index',compact('settings'));
    }

    public function update(Request $request){
        $settings= Settings::find(1);
        $settings->title=$request->title;
        $settings->status=$request->active;
        $settings->facebook=$request->facebook;
        $settings->linkedin=$request->linkedin;
        $settings->github=$request->github;

        if ($request->hasFile('logo')){
            $logo=Str::slug($request->title).'-logo'.'.'.$request->logo->getClientOriginalExtension();
            $request->logo->move(public_path('uploads'),$logo);
            $settings->logo='uploads/'.$logo;
        }
        if ($request->hasFile('favicon')){
            $favicon=Str::slug($request->title).'-favicon'.'.'.$request->favicon->getClientOriginalExtension();
            $request->favicon->move(public_path('uploads'),$favicon);
            $settings->favicon='uploads/'.$favicon;
        }

        $settings->save();
        toastr()->success('Site bilgilerini güncelleme işlemi başarıyla gerçekleşti!');
        return redirect()->back();
    }
}
