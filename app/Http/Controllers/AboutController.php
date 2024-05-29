<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\About; 

class AboutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $integrated_system = About::oldest()->get();
        
        return view('about',
                compact('integrated_system'
                    ));
    }
    public function aboutupdate(Request $request){
        //
        $id = $request->get('id');
        $nama = $request->get('nama-edit');
        $link = $request->get('link-edit');
        $deskripsi = $request->get('deskripsi-edit');
        
        $data = About::where('id',$id)->update(array(
        'nama' => $nama,
        'link' => $link,
        'deskripsi' => $deskripsi
        ));

        return redirect('about');
    }
    public function aboutedit($id){
        $editcamera = About::select('*')
                    ->where('id', $id)
                    ->get();

        return view('admin.sensor.aboutedit',compact('editcamera'));
    }
    
}
