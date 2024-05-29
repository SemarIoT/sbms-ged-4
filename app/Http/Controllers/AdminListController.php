<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AdminListController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /*public function index(){
        $admin = User::latest();
        return view('admin.list',compact('admin'));
    }*/
    public function index()
    {
        $user = User::where('level','User')->latest()->paginate(50);
        $admin = User::where('level','Admin')->latest()->paginate(50);
        $developer = User::where('level','Developer')->latest()->paginate(50);
        return view ('admin.list',compact('admin','user','developer'))
        ->with('i', (request()->input('page', 1) -1) * 5)
        ->with('j', (request()->input('page', 1) -1) * 5)
        ->with('k', (request()->input('page', 1) -1) * 5);
    }
    

    public function storeUser(Request $request){
        //
       // dd($request);
        request()->validate(
            [
                'name'=> 'required',
                'username' => 'required',
                'level'=> 'required',
                'email'=> 'required',
                'password' => 'required',
            ]);

        $data = new User;
        $data->name = $request->name;
        $data->username = $request->username;
        $data->level = $request->level;
        $data->email = $request->email;
        $data->password = Hash::make($request->password);
        $data->save();

        return redirect('daftar-admin');
    }

    public function showUser($id){
        $user = User::select('name','username','level','email')->where('id',$id)->get();
        return response()->json($user[0]);
    }

    public function updateUser(Request $request){
        //
        $id = $request->get('id');
        $name = $request->get('name-edit');
        $username = $request->get('username-edit');
        $level = $request->get('level-edit');
        $email = $request->get('email-edit');
       

        $data = User::where('id',$id)->update(array(
        'name' => $name,
        'username' =>$username,
        'level'=>$level,
        'email' => $email,
        

        ));

        return redirect('daftar-admin');
    }

    public function delete($id){
		$data = User::findorfail($id);
		$data->delete();

        return redirect('daftar-admin');
	}
    public function editUser($id){
        $edituser = User::select('*')
                    ->where('id', $id)
                    ->get();

        return view('admin.edit',compact('edituser'));
    }
    
}
