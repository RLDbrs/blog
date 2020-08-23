<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use\App\Models\Page;
use File;

class PageController extends Controller
{
    public function index(){
      $pages=page::all();
      return view('back.pages.index',compact('pages'));
    }


    public function orders(Request $request){
      foreach ($request->get('page') as $key => $order){
        Page::where('id',$order)->update(['order'=>$key]);
      }
    }



    public function create(){
      return view('back.pages.create');
    }




    public function update($id){
      $page=Page::findOrFail($id);
      return view('back.pages.update',compact('page'));
    }





    public function updatePost(Request $request, $id)
    {
      $request->validate([
        'title'=>'min:3',
        'image'=>'image|mimes:jpeg,png,jpg,gif|max:9216',
      ]);
        $page=Page::findOrFail($id);
        $page->title=$request->title;
        $page->content=$request->content;
        $page->slug=str_slug($request->title);


        if($request->hasFile('image')){
          $imageName=str_slug($request->title).".".$request->image->getClientOriginalExtension();
          $request->image->move(public_path('uploads'),$imageName);
          $page->image='uploads/'.$imageName;
          //$page->image=asset('uploads/').'/'.$imageName;
        }
        $page->save();
        toastr()->success('Başarılı', 'sayfa başarı ile Güncellendi');
        return redirect()->route('admin.page.index');
    }





    public function delete($id){
      $page=Page::find($id);
      if(File::exists($page->image)){
        File::delete(public_path($page->image));
      }
      $page->delete();
      toastr()->success(' sayfa başarı ile silindi');
      return redirect()->route('admin.page.index');
    }






    public function post(Request $request){
      $request->validate([
        'title'=>'min:3',
        'image'=>'required|image|mimes:jpeg,png,jpg,gif|max:2048',
      ]);

      $last=page::orderBy('order','desc')->first();

        $page=new Page;
        $page->title=$request->title;
        $page->content=$request->content;
        $page->order=$last->order+1;
        $page->slug=str_slug($request->title);


        if($request->hasFile('image')){
          $imageName=str_slug($request->title).".".$request->image->getClientOriginalExtension();
          $request->image->move(public_path('uploads'),$imageName);
          $page->image='uploads/'.$imageName;
          //$page->image=asset('uploads/').'/'.$imageName;
        }
        $page->save();
        toastr()->success('sayfa başarı ile oluşturuldu');
        return redirect()->route('admin.page.index');
    }

}
