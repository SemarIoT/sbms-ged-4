<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\DoorlockAccess;
use App\Models\DoorlockHistory;
use App\Models\DoorlockState;
use Carbon\Carbon;

class DoorlockStateController extends Controller
{
    public function index()
    {
        return view('security.doorlock');
    }
    public function doorlock_open()
    {
        $posts = DoorlockState::where('id_ruang', 1)->Paginate(1);
        return view('security.doorlockopen', compact('posts'));
    }

    public function proses_token_doorlock_iot(Request $request)
    {
        $tokenData = DoorlockAccess::pluck('token')->toArray();
        $inputToken = $request->input('username');
        // Mencocokkan token dari user yang telah disetujui saja
        $periksa = DoorlockAccess::where('token', $inputToken)->where('is_aktif', '1')->first();

        if (in_array($inputToken, $tokenData)) {
            if ($periksa) {

                DoorlockState::where('id_ruang', 1)->update(['status' => 49]);
                sleep(10);
                DoorlockState::where('id_ruang', 1)->update(['status' => 48]);

                $ruang = DoorlockState::where('id_ruang', 1)->first();
                $history = DoorlockAccess::where('token', $inputToken)->first();
                $data = new DoorlockHistory;
                $data->id_ruang = $ruang->id_ruang;
                $data->ruang = $ruang->ruang;
                $data->nama = $history->nama;
                $data->status = $history->token;

                $data->save();

                return redirect()->back()->withErrors(['login_gagal' => 'Pintu Telah Terkunci Kembali']);
            }
        }

        return redirect()->back()->withErrors(['login_gagal' => 'Token Tidak Terdaftar']);
    }

    public function data_history()
    {
    }

    public function change_state_doorlock($id)
    {
        $getStatus = DoorlockState::select('status')->where('id', $id)->first();
        @dd($getStatus);
        if ($getStatus->status == 49) {
            $status = 48;
        } else {
            $status = 49;
        }
        DoorlockState::where('id', $id)->update(['status' => $status]);

        return back();
    }
    public function storemandiri_doorlockAccess(Request $request)
    {
        request()->validate(
            [
                'nama' => 'required',
                'token' => 'required',
            ]
        );

        $data = new DoorlockAccess;
        $data->nama = $request->nama;
        $data->token = $request->token;
        $data->level_akses = '1';
        $data->is_aktif = '0';
        $data->save();

        return redirect('doorlock-iot');
    }
    public function Doorlock($id)
    {
        $data = DoorlockState::where('id', $id)->pluck('status');
        return $data;
    }
}
