<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PinpointMap;
class PinpointMapController extends Controller
{
    public function pinpointmapupdate(Request $request){
		$this->validate($request, [
			'map' => 'required|file|image|mimes:jpeg,png,jpg|max:16384',
			
		]);
 
		// menyimpan data file yang diupload ke variabel $file
		$file = $request->file('map');
 
		$nama_file = time()."_".$file->getClientOriginalName();
 
      	        // isi dengan nama folder tempat kemana file diupload
		$tujuan_upload = 'data_file';
		$file->move($tujuan_upload,$nama_file);
 
		PinpointMap::create([
			'map' => $nama_file
		]);
 
		return redirect()->back();
	}

}
