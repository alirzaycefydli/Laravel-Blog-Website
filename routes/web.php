<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

/*
| Back-End Routes
*/

Route::get('offline',function (){
   return view('front.offline');
});

Route::prefix('admin')->middleware('LoginCheckedMiddleware')->group(function () {
    Route::get('login', 'back\AuthController@login')->name('admin.login');
    Route::post('loginPost', 'back\AuthController@loginPost')->name('admin.login.post');
});


Route::prefix('admin')->middleware('MyAuthMiddleware')->group(function () {
    Route::get('panel', 'back\AdminController@index')->name('admin');
    //Routes for articles
    Route::resource('makaleler', 'back\ArticleController');
    Route::get('/switch', 'back\ArticleController@switchStatus')->name('switchStatus');
    Route::get('/deletearticle/{id}', 'back\ArticleController@delete')->name('delete.article');
    Route::get('/silinen-makaleler', 'back\ArticleController@trashedArticle')->name('deleted.article');
    Route::get('/recoverarticle/{id}', 'back\ArticleController@recoverArticle')->name('recover.article');
    Route::get('/deletecompletely/{id}', 'back\ArticleController@deleteCompletely')->name('delete.article.completely');
    //Routes for categories
    Route::get('kategoriler', 'back\CategoryController@index')->name('categories');
    Route::get('kategori/durum', 'back\CategoryController@switch')->name('category.switch');
    Route::post('kategori/ekle', 'back\CategoryController@create')->name('category.create');
    Route::get('kategori/getdata', 'back\CategoryController@getData')->name('category.getdata');
    Route::post('kategori/guncelle', 'back\CategoryController@update')->name('category.update');
    Route::post('kategori/sil', 'back\CategoryController@delete')->name('category.delete');
    //Routes for pages
    Route::get('sayfalar', 'back\PageController@index')->name('pages');
    Route::get('/switch/page', 'back\PageController@switchPage')->name('switchPage');
    Route::get('sayfalar/create', 'back\PageController@create')->name('sayfalar.create');
    Route::post('sayfalar/create', 'back\PageController@post')->name('post.page');
    Route::get('sayfalar/guncelle/{id}', 'back\PageController@edit')->name('page.edit');
    Route::post('sayfalar/guncelle/{id}', 'back\PageController@update')->name('page.update');
    Route::get('/delete/page/{id}', 'back\PageController@delete')->name('delete.page');
    Route::get('/sayfa/siralama', 'back\PageController@orders')->name('page.orders');
    //Routes for settings
    Route::get('ayarlar', 'back\SettingController@index')->name('settings');
    Route::post('ayarlar/guncelle', 'back\SettingController@update')->name('settings.update');


    Route::get('logout', 'back\AuthController@logout')->name('admin.logout');
});


/*
| Front-End Routes
*/
Route::get('/', 'front\HomeController@index')->name('homepage');
Route::get('/kategori/{category}', 'front\HomeController@category')->name('category');
Route::get('/iletisim', 'front\HomeController@contact')->name('contact');
Route::post('/iletisim', 'front\HomeController@contactpost')->name('contact.post');
Route::get('/{category}/{slug}', 'front\HomeController@details')->name('blog.single');
Route::get('/{slug}', 'front\HomeController@page')->name('page');
