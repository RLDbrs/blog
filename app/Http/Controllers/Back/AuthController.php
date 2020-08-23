<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(){
      return view('back.auth.login');
    }
    public function loginpost(Request $request){
      if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
        toastr()->success('Tekrardan Hoşgeldin'.Auth::user()->name);
        return redirect()->route('admin.dashboard'); die;
      }
      return redirect()->route('admin.login')->withErrors('email adresi ya da şifre hatalı');
    //  dd($request->post());  //gelen verideki değerleri ekrana basar print_r ile aynı işlemi yapar
    }
    public function logout(){
      Auth::logout();
    return  redirect()->route('admin.login');
    }
}
