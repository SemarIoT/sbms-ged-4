<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Camera;

class CameraController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        $camera = Camera::oldest()->paginate(100);
        return view('security.camera',compact('camera'));
    }
    public function storeCameraList(Request $request){
       
        request()->validate(
            [
                'nama'=> 'required',
                
                
            ]);

        $data = new Camera;
        $data->nama = $request->nama;
        $data->link = $request->link;
       
        $data->save();

        return redirect('daftar-sensor');
    }

    public function updateCameraList(Request $request){
        //
        $id = $request->get('id');
        $nama = $request->get('nama-edit');
        $link = $request->get('link-edit');
        
        $data = Camera::where('id',$id)->update(array(
        'nama' => $nama,
        'link' => $link
        ));

        return redirect('daftar-sensor');
    }

    public function deleteCameraList($id){
		$data = Camera::findorfail($id);
		$data->delete();

        return redirect('daftar-sensor');
	}
    public function editCameraList($id){
        $editcamera = Camera::select('*')
                    ->where('id', $id)
                    ->get();

        return view('admin.sensor.cameraedit',compact('editcamera'));
    }
}

