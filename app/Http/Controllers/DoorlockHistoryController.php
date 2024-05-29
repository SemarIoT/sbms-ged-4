<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DoorlockHistory;

class DoorlockHistoryController extends Controller
{
    public function index()
    {
        $doorlockhistory = DoorlockHistory::latest()->paginate(100);

        return view ('admin.doorlockhistory',compact('doorlockhistory'))
        ->with('i', (request()->input('page', 1) -1) * 5);
    }
}
