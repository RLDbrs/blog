<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;

class CategoryController extends Controller
{
  public function index(){
    $categories=Category::all();
    return view('Back.categories.index',compact('categories'));
  }




  public function create(Request $request){
    $isExist=Category::whereSlug(str_slug($request->category))->first();
    if($isExist){
      toastr()->error($request->category.' aynı kategoriden bulunuyor');
      return redirect()->back();
    }
    $category=new Category;
    $category->name=$request->category;
    $category->slug=str_slug($request->category);
    $category->save();
    toastr()->success(' Kategori oluşturuldu');
    return redirect()->back();
  }


  public function getData(Request $request){
    $category=Category::findOrFail($request->id);
    return response()->json($category);
  }



  public function update(Request $request){
    $isSlug=Category::whereSlug(str_slug($request->slug))->whereNotIn('id',[$request->id])->first();
    $isName=Category::whereName($request->category)->whereNotIn('id',[$request->id])->first();
    if($isSlug or $isName){
      toastr()->error($request->category.' aynı kategoriden bulunuyor');
      return redirect()->back();
    }
    $category = Category::find($request->id);
    $category->name=$request->category;
    $category->slug=str_slug($request->slug);
    $category->save();
    toastr()->success(' Kategori güncellendi');
    return redirect()->back();
  }




  public function delete(Request $request){
      $category = Category::findOrFail($request->id);
      $defaultCategory = Category::find(1);
      if($category->id==1){
          toastr()->error('Bu kategori silinemez.');
          return redirect()->back();
      }
      $allArticle = Article::withTrashed()->where('category_id',$category->id);
      $allArticles = Article::withTrashed()->where('category_id',$category->id)->get();
      $count = $category->articleCount();
      $message = '';
      if($count > 0 ){
          $allArticle->update(['category_id'=>1]);
          $message = 'Silinen kategoriye ait '.$count.' yazı '.$defaultCategory->name.' kategorisine taşındı.';
      }elseif ($count==0 and count($allArticles)>0) {
           $allArticle->update(['category_id'=>1]);
      }
      $category->delete();
      toastr()->success($message, 'Kategori başarıyla silindi', ['timeOut' => 4000]);
      return redirect()->back();
   }

}
