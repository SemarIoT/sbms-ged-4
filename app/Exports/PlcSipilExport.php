<?php

namespace App\Exports;

use App\Models\plc_sipil;
use App\Models\Driver;
use Maatwebsite\Excel\Concerns\WithHeadings;    
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;

class PlcSipilExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings() :array
    {
        return ["#","timestamp","posisi","gaya","gayatarik","gayatekan"];
    }
    public function collection()
    {
        return plc_sipil::select('id','created_at','distance','forces','gayatarik','gayatekan')->get();
    }
    
}
