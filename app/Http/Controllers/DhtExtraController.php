<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DhtExtra;
use App\Models\About;
class DhtExtraController extends Controller
{
        public function __construct() 
        {
            $this->middleware('auth');
        }
    
    
        public function storeDhtxList(Request $request){
           
            request()->validate(
                [
                    'nama'=> 'required',
                    'id_nama'=> 'required'
                ]);
    
            $data = new DhtExtra;
            $data->nama = $request->nama;
            $data->id_nama = $request->id_nama;
            $data->status = $request->status;
            $data->save();
    
            return redirect('daftar-sensor');
        }
    
        public function showDhtxList($id){
            $DhtExtrashow = DhtExtra::where('id',$id)->get();
            $about = About::oldest()->get();
            return view('admin.sensor.dhtextrashow',compact('DhtExtrashow','about'));
        }
    
        public function updateDhtxList(Request $request){
            //
            $id = $request->get('id');
            $nama = $request->get('nama-edit');
            
            
            $data = DhtExtra::where('id',$id)->update(array(
            'nama' => $nama,
            
            
            ));
    
            return redirect('daftar-sensor');
        }
    
        public function deleteDhtxList($id){
            $data = DhtExtra::findorfail($id);
            $data->delete();
    
            return redirect('daftar-sensor');
        }
        public function editDhtxList($id){
            $editDhtExtra = DhtExtra::select('*')
                        ->where('id', $id)
                        ->get();
    
            return view('admin.sensor.dhtextraedit',compact('editDhtExtra'));
        }
        public function changeDhtStatus($id){
            $getStatus = DhtExtra::select('status')->where('id',$id)->first();
            
            if($getStatus->status==1){
                $status = 0;
              
            }else{
                $status = 1;
                
            }
            DhtExtra::where('id',$id)->update(['status'=>$status]);
                   
            return redirect()->back();
        }
        public function showdhtapi(){
            
            $about = About::oldest()->get();
            return view('admin.sensor.dhtshow',compact('about'));
        }
}
