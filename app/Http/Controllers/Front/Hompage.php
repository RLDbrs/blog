<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Mail;
use App\Models\Article;
use App\Models\Category;
use App\Models\Page;
use App\Models\Contact;
use App\Models\Config;
class Hompage extends Controller
{
  public function __construct(){
    if(Config::find(1)->active==0){
      return redirect()->to('aktif-değil')->send();
    }
    view()->share('pages',Page::orderBy('order','ASC')->get());
    view()->share('categories',Category::inRandomOrder()->get());
  }
    public function index(){
      $data['articles']=Article::orderBy('created_at','DESC')->paginate(4);
      $data['articles']->withPath(url('sayfa'));
      return view('front.homepage',$data);
    }
    public function single($category,$slug){
      $category=Category::whereSlug($category)->first() ?? abort(403,'Böyle bir kategori bulunamadı');
      $article=Article::whereSlug($slug)->whereCategoryId($category->id)->first() ?? abort(403,'Böyle bir sayfa bulunamadı');
      $article->increment('hit');
      $data['article']=$article;
      return view('front.single',$data);
    }
    public function category($slug){
      $category=Category::whereSlug($slug)->first() ?? abort(403,'Böyle bir kategori bulunamadı');
      $data['category']=$category;
      $data['articles']=Article::where('category_id',$category->id)->orderBy('created_at','DESC')->paginate(2);
      return view('front.category',$data);
    }
    public function page($slug){
      $page=Page::whereSlug($slug)->first() ?? abort('böyle bir sayfa bulunamadı');
      $data['page']=$page;
      return view('front.page',$data);

    }
    public function contact(){
      return view('front.contact');
    }
    public function contactpost(Request $request){

      $rules=[
        'name'=>'required|min:5',
        'email'=>'required|email',
        'topic'=>'required',
        'message'=>'required|min:10',
      ];

    $validate=Validator::make($request->post(),$rules);

    if($validate->fails()){
      return redirect()->route('contact')->withErrors($validate)->withInput();
    }
    Mail::send([],[],function($message) use($request){
                $message->from('rldblog@gmail.com','RLD BLOG');
                $message->to('rld@gmail.com');
                $message->setBody(' Mesajı gönderen :'.$request->name.'<br/>
                           Mesajı Gönderen Mail :'.$request->email.'<br/>
                           Mesaj Konusu :'.$request->topic.'<br/>
                           Mesaj :'.$request->message.'<br/><br/>
                           Mesaj Gönderilme Tarihi :'.now().'','text/html');
                $message->subject($request->name.' iletişim mesajı gönderdi');
              });


    //  $contact = new Contact;
    //  $contact->name=$request->name;
    //  $contact->email=$request->email;
    //  $contact->topic=$request->topic;
    //  $contact->message=$request->message;
    //  $contact->save();
      return redirect()->route('contact')->with('success', 'mesajınız RLD STUDİO ya iletildi');
    }
}
