<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FireAlarm;
use App\Models\About;
class FireAlarmController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth');
    }
    public function showData(){
        $posts = FireAlarm::latest()->Paginate(10);
        
       return view('security.fire-alarm',compact('posts'));
   } 
   public function changeStatus($id){
    $getStatus = FireAlarm::select('status')->where('id',$id)->first();
    if($getStatus->status==1){
        $status = 0;
    }else{
        $status = 1;
    }
    FireAlarm::where('id',$id)->update(['status'=>$status]);
    
    return back();
    }

    public function storeFireAlarmList(Request $request){
       
        request()->validate(
            [
                'nama'=> 'required',
                
            ]);

        $data = new FireAlarm;
        $data->nama = $request->nama;
        $data->status = $request->status;
       
        $data->save();

        return redirect('daftar-sensor');
    }

    public function showFireAlarmList($id){
        $firealarmshow = FireAlarm::where('id',$id)->get();
        $about = About::oldest()->get();
        return view('admin.sensor.firealarmshow',compact('firealarmshow','about'));
    }

    public function updateFireAlarmList(Request $request){
        //
        $id = $request->get('id');
        $nama = $request->get('nama-edit');
        
        $data = FireAlarm::where('id',$id)->update(array(
        'nama' => $nama
        ));

        return redirect('daftar-sensor');
    }

    public function deleteFireAlarmList($id){
		$data = FireAlarm::findorfail($id);
		$data->delete();

        return redirect('daftar-sensor');
	}
    public function editFireAlarmList($id){
        $editfirealarm = FireAlarm::select('*')
                    ->where('id', $id)
                    ->get();

        return view('admin.sensor.firealarmedit',compact('editfirealarm'));
    }
}
