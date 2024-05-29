<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DoorlockAccess;
use App\Models\DoorlockState;

class DoorlockAccessController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $doorlockaccess = DoorlockAccess::where('is_aktif',1)->oldest()->Paginate(100);
        $doorlockaccessvalidate = DoorlockAccess::where('is_aktif',0)->oldest()->Paginate(100);

        return view ('admin.doorlockaccesslist',compact('doorlockaccess','doorlockaccessvalidate'))
        ->with('i', (request()->input('page', 1) -1) * 5)
        ->with('j', (request()->input('page', 1) -1) * 5);
    }
    public function store_doorlockAccess(Request $request){
       
        request()->validate(
            [
                'nama'=> 'required',
                'token'=> 'required',
                'level_akses'=> 'required'                
            ]);

        $data = new DoorlockAccess;
        $data->nama = $request->nama;
        $data->token = $request->token;
        $data->level_akses = $request->level_akses;
        $data->is_aktif = '1';
        $data->save();

        return redirect('doorlock_list');
    }


    public function update_doorlockAccess(Request $request){
        
        $id = $request->get('id');
        $nama = $request->get('nama-edit');
        $token = $request->get('token-edit');
        $level = $request->get('level-edit');
        
        $data = DoorlockAccess::where('id',$id)->update(array(
        'nama' => $nama,
        'token' => $token,
        'level_akses' => $level
        ));

        return redirect('doorlock_list');
    }

    public function delete_doorlockAccess($id){
		$data = DoorlockAccess::findorfail($id);
		$data->delete();

        return redirect('doorlock_list');
	}
    public function edit_doorlockAccess($id){
        $editdoorlockAccess = DoorlockAccess::select('*')
                    ->where('id', $id)
                    ->get();

        return view('admin.doorlockaccessedit',compact('editdoorlockAccess'));
    }
    public function validate_doorlockAccess($id){
        $doorlockaccessvalidate = DoorlockAccess::where('id',$id)->update(array(
            'is_aktif' => '1'
            ));

        return redirect('doorlock_list');
    }
    public function storemandiri_doorlockAccess(Request $request){
       
        request()->validate(
            [
                'nama'=> 'required',
                'token'=> 'required',                
            ]);

        $data = new DoorlockAccess;
        $data->nama = $request->nama;
        $data->token = $request->token;
        $data->level_akses = '1';
        $data->is_aktif = '0';
        $data->save();

        return redirect('doorlock-iot');
    }

    //list room
    public function doorlock_list_room()
    {
        $doorlockroom = DoorlockState::oldest()->Paginate(100);
       
        return view ('admin.doorlockaccesslistroom',compact('doorlockroom'))
        ->with('i', (request()->input('page', 1) -1) * 5);
    }
    public function store_doorlockRoom(Request $request){
       
        request()->validate(
            [
                'ruang'=> 'required',
                'id_ruang'=> 'required'                
            ]);

        $data = new DoorlockState;
        $data->ruang = $request->ruang;
        $data->id_ruang = $request->id_ruang;
        $data->status = '0';
        
        $data->save();

        return redirect('doorlock_list_room');
    }


    public function update_doorlockRoom(Request $request){
        
        $id = $request->get('id');
        $ruang = $request->get('ruang-edit');
        
        
        
        $data = DoorlockState::where('id',$id)->update(array(
        'ruang' => $ruang,
        
        ));

        return redirect('doorlock_list_room');
    }

    public function delete_doorlockRoom($id){
		$data = DoorlockState::findorfail($id);
		$data->delete();

        return redirect('doorlock_list_room');
	}
    public function edit_doorlockRoom($id){
        $editdoorlockAccessroom = DoorlockState::select('*')
                    ->where('id', $id)
                    ->get();

        return view('admin.doorlockaccessroomedit',compact('editdoorlockAccessroom'));
    }
}
