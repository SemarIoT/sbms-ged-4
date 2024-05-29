<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\kontrol;

class KontrolController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showData(){
        $posts = kontrol::latest()->Paginate(1);
        
       return view('environment.kontrol',compact('posts'));
   } 
   public function changeStatus($id){
    $getStatus = kontrol::select('status')->where('id',$id)->first();
    if($getStatus->status==1){
        $status = 0;
    }else{
        $status = 1;
    }
    kontrol::where('id',$id)->update(['status'=>$status]);
    return redirect()->back();
    }
   
}
