<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function index()
    {
        if ($user = Auth::user()) {
            if ($user->level == 'admin') {
                return redirect()->intended('admin');
            } elseif ($user->level == 'editor') {
                return redirect()->intended('editor');
            }
        }
        return view('auth.login');
    }

    public function proses_login(Request $request)
    {
        request()->validate(
            [
                'username' => 'required',
                'password' => 'required',
            ]
        );

        $kredensil = $request->only('username', 'password');

        if (Auth::attempt($kredensil)) {
            $user = Auth::user();
            if ($user->level == 'admin') {
                return redirect('dashboard'); //->intended('admin');
            } elseif ($user->level == 'user') {
                return redirect('dashboard'); //->intended('editor');
            } elseif ($user->level == 'developer') {
                return redirect('dashboard'); //->intended('editor');
            }
            return redirect('dashboard'); //->intended('/');
        }

        return redirect('login')
            ->withInput()
            ->withErrors(['login_gagal' => 'Username dan Password tidak terdaftar']);
    }


    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        return Redirect('/');
    }

    public function profile()
    {

        return view('auth.profile');
    }

    public function showprofile($id)
    {
        $edituser = User::select('*')
            ->where('id', $id)
            ->get();

        return view('auth.updateprofile', compact('edituser'));
    }
    public function updateprofile(Request $request)
    {
        //
        $id = $request->get('id');
        $name = $request->get('name-edit');
        $username = $request->get('username-edit');

        $email = $request->get('email-edit');


        $data = User::where('id', $id)->update(array(
            'name' => $name,
            'username' => $username,

            'email' => $email,
        ));

        //return redirect()->back()->with("success","Profile changed successfully !");
        return redirect('profile');
    }

    public function showChangePasswordForm()
    {

        return view('auth.changepassword');
    }

    public function changePassword(Request $request)
    {

        if (!(\Hash::check($request->get('current-password'), \Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error", "Your current password does not matches with the password you provided. Please try again.");
        }

        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            //Current password and new password are same
            return redirect()->back()->with("error", "New Password cannot be same as your current password. Please choose a different password.");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:4|confirmed',  
        ]);

        //Change Password
        $user = \Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        return redirect()->back()->with("success", "Password changed successfully !");
    }
}
