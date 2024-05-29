<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IntegratedSystem;
class IntegratedSystemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $integrated_system = IntegratedSystem::oldest()->get();
        
        return view('integratedsystem',
                compact('integrated_system'
                    ));
    }
    public function storeIntegratedSystemList(Request $request){
       
        request()->validate(
            [
                'nama'=> 'required',
                
                
            ]);

        $data = new IntegratedSystem;
        $data->nama = $request->nama;
        $data->link = $request->link;
        $data->deskripsi = $request->deskripsi;
       
        $data->save();

        return redirect('integratedsystem');
    }

    public function updateIntegratedSystemList(Request $request){
        //
        $id = $request->get('id');
        $nama = $request->get('nama-edit');
        $link = $request->get('link-edit');
        $deskripsi = $request->get('deskripsi-edit');
        
        $data = IntegratedSystem::where('id',$id)->update(array(
        'nama' => $nama,
        'link' => $link,
        'deskripsi' => $deskripsi
        ));

        return redirect('integratedsystem');
    }

    public function deleteIntegratedSystemList($id){
		$data = IntegratedSystem::findorfail($id);
		$data->delete();

        return redirect('integratedsystem');
	}
    public function editIntegratedSystemList($id){
        $editcamera = IntegratedSystem::select('*')
                    ->where('id', $id)
                    ->get();

        return view('admin.sensor.integratedsystemedit',compact('editcamera'));
    }
}
