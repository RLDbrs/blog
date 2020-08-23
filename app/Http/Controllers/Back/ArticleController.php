<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\File;


class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $articles=Article::orderBy('created_at','desc')->get();
        return view('back.articles.index',compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $categories=Category::all();
        return view('back.articles.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $request->validate([
        'title'=>'min:3',
        'image'=>'required|image|mimes:jpeg,png,jpg,gif|max:2048',
      ]);
        $article=new Article;
        $article->title=$request->title;
        $article->category_id=$request->category;
        $article->content=$request->content;
        $article->slug=str_slug($request->title);


        if($request->hasFile('image')){
          $imageName=str_slug($request->title).".".$request->image->getClientOriginalExtension();
          $request->image->move(public_path('uploads'),$imageName);
          $article->image='uploads/'.$imageName;
          //$article->image=asset('uploads/').'/'.$imageName;
        }
        $article->save();
        toastr()->success('Başarılı', 'Makale başarı ile oluşturuldu');
        return redirect()->route('admin.makaleler.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $article=Article::findOrFail($id);
      $categories=Category::all();
        return view('back.articles.update',compact('categories','article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $request->validate([
        'title'=>'min:3',
        'image'=>'image|mimes:jpeg,png,jpg,gif|max:2048',
      ]);
        $article=Article::findOrFail($id);
        $article->title=$request->title;
        $article->category_id=$request->category;
        $article->content=$request->content;
        $article->slug=str_slug($request->title);


        if($request->hasFile('image')){
          $imageName=str_slug($request->title).".".$request->image->getClientOriginalExtension();
          $request->image->move(public_path('uploads'),$imageName);
          $article->image='uploads/'.$imageName;
          //$article->image=asset('uploads/').'/'.$imageName;
        }
        $article->save();
        toastr()->success('Başarılı', 'Makale başarı ile Güncellendi');
        return redirect()->route('admin.makaleler.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function delete($id){
       Article::find($id)->delete();
       toastr()->success(' makale geri dönüşüm kutusuna gönderildi');
       return redirect()->route('admin.makaleler.index');
     }
     public function trashed(){
       $articles=Article::onlyTrashed()->orderBy('deleted_at','desc')->get();
       return view('back.articles.trashed',compact('articles'));
     }
     public function recover($id){
       Article::onlyTrashed()->find($id)->restore();
       toastr()->success(' makale başarı ile geri yüklendi');
       return redirect()->route('admin.makaleler.index');
     }
     public function HardDelete($id){
       $article=Article::onlyTrashed()->find($id);
       if(File::exists($article->image)){
         File::delete(public_path($article->image));
       }
       $article->ForceDelete();
       toastr()->success(' makale başarı ile silindi');
       return redirect()->route('admin.makaleler.index');
     }
    public function destroy($id)
    {
        //
    }
}
