<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
*/
Route::get('aktif-değil',function(){
  return view('front.offline');
});

Route::prefix('admin')->name('admin.')->middleware('isLogin')->group(function(){
  Route::get('giris','Back\AuthController@login')->name('login');
  Route::post('giris','Back\AuthController@loginpost')->name('login.post');
});
Route::prefix('admin')->name('admin.')->middleware('isAdmin')->group(function(){
  Route::get('panel','Back\Dashboard@index')->name('dashboard');
  //MAKALELER
  Route::get('makaleler/silinenler','Back\ArticleController@trashed')->name('trashed.article');
  Route::resource('makaleler','Back\ArticleController');
  Route::get('/deletearticle/{id}','Back\ArticleController@delete')->name('delete.article');
  Route::get('/harddeletearticle/{id}','Back\ArticleController@HardDelete')->name('hard.delete.article');
  Route::get('recoverarticle/{id}','Back\ArticleController@recover')->name('recover.article');
  //KATEGORİLER
  Route::get('/Kategoriler','Back\CategoryController@index')->name('category.index');
  Route::post('/Kategoriler/create','Back\CategoryController@create')->name('category.create');
  Route::post('/Kategoriler/update','Back\CategoryController@update')->name('category.update');
  Route::post('/Kategoriler/delete','Back\CategoryController@delete')->name('category.delete');
  Route::get('/Kategori/getData','Back\CategoryController@getData')->name('category.getData');
  //PAGE
  Route::get('/sayfalar','Back\PageController@index')->name('page.index');
  Route::get('/sayfalar/olustur','Back\PageController@create')->name('page.create');
  Route::get('/sayfalar/guncelle/{id}','Back\PageController@update')->name('page.edit');
  Route::post('/sayfalar/guncelle/{id}','Back\PageController@updatePost')->name('page.edit.post');
  Route::post('/sayfalar/olustur','Back\PageController@post')->name('page.create.post');
  Route::get('/sayfa/sil/{id}','Back\PageController@delete')->name('page.delete');
  Route::get('/sayfa/siralama','Back\PageController@orders')->name('page.orders');
  //config
  Route::get('/ayarlar','Back\ConfigController@index')->name('config.index');
  Route::post('/ayarlar/update','Back\ConfigController@update')->name('config.update');
  //
  Route::get('cikis','Back\AuthController@logout')->name('logout');
});



/*
|--------------------------------------------------------------------------
| Front Routes
|--------------------------------------------------------------------------
*/

Route::get('/','Front\Hompage@index')->name('hompage');
Route::get('/sayfa','Front\Hompage@index');
Route::get('/iletisim','Front\Hompage@contact')->name('contact');
Route::post('/iletisim','Front\Hompage@contactpost')->name('contact.post');
Route::get('/kategori/{category}','Front\Hompage@category')->name('category');
Route::get('/{category}/{slug}','Front\Hompage@single')->name('single');
Route::get('/{sayfa}','Front\Hompage@page')->name('page');
