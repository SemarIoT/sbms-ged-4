<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Carbon;
// use Illuminate\Support\Collection;
use App\Models\DhtSensor;
use App\Models\DhtExtraData;
// use App\Models\LightDimmer;
use App\Models\Light;
use App\Models\FireAlarm;
use App\Models\Energy;
use App\Models\EnergyOutlet;
use App\Models\EnergyOutletMaster;
use App\Models\EnergyPanel;
use App\Models\EnergyPanelMaster;
// use App\Models\Pinpoint;
use DB;

class SensorDataController extends Controller
{
    // Ambil Data dari DB
    public function getDht(){
        // $data = DhtSensor::latest()->get(); // Semuanya
        $data = DhtSensor::latest()->limit(100)->get(); // Limit 100 biar tidak berat loadnya
        return $data;
    }

    // Masukkan data POST ke DB
    public function postDht(Request $request){
        $data = new DhtSensor;
        $data->temperature = $request->temperature;
        $data->humidity = $request->humidity;
        $data->save();
        return 201;
    }

    // Ambil data DHT ke-2 ke DB
    public function getDhtExtra(){
        $data = DhtExtraData::latest()->get();
        return $data;
    }

    // Masukkan data yang diPOST ke DB
    public function postDhtExtra(Request $request){
        $data = new DhtExtraData;
        $data->dht = $request->dht;
        $data->temperature = $request->temperature;
        $data->humidity = $request->humidity;
        $data->save();
        return 201;
    }

    // public function getAllDimmer(){
    //     $data = LightDimmer::get();
    //     return $data;
    // }

    // public function getDimmer($id){
    //     $data = LightDimmer::where('id',$id)->value('nilai');
    //     return $data;
    // }

    // public function postDimmer(Request $request, $id){
    //     $data = LightDimmer::where('id',$id)->update(array(
    //         'nilai'=>$request->value
    //     ));
    //     return 201;
    // }
    
    public function getLightAll(){
        $data = Light::get();
        return $data;
    }

    public function getLight($id){
        if (Light::where('id',$id)->exists()){
            $data = Light::where('id',$id)->pluck('status');
            return $data;
        }
        else {
            return response()->json([
                "message" => "Data not found"
            ], 404);
        }
    }

    
    public function postLight(Request $request, $id){
        // put data at id = $id
        if (Light::where('id', $id)->exists()) {
            $data = Light::find($id);
            $data->status = is_null($request->status) ? $data->status : $request->status;
            $data->save();
    
            return response()->json([
                "message" => "Data's records updated successfully"
            ], 200);
        }
        else {
            return response()->json([
                "message" => "Data not found"
            ], 404);
        }
    }

    public function getAllEnergy(){
        // get all data
        $data = Energy::latest()->take(300)->get();//->toJson(JSON_PRETTY_PRINT);
        return response($data, 200);
    }
    
    public function addData(Request $request){
        // Post Data Energy terus menerus
        
        $data = new Energy;
        $data->id_kwh = $request->id_kwh;
        $data->frekuensi = $request->frekuensi;
        $data->arus = $request->arus;
        $data->tegangan = $request->tegangan;
        $data->active_power = $request->active_power;
        $data->reactive_power = $request->reactive_power;
        $data->apparent_power = $request->apparent_power;
        $data->save();
    
        return response()->json([
            "message" => "data record added"
        ], 201);
    }

    public function getData($id){
        // get data at id = $id
        if (Energy::where('id_kwh', $id)->exists()) {
            $data = Energy::where('id_kwh', $id)->get();//()->toJson(JSON_PRETTY_PRINT);
            return response($data, 200);
        } else {
            return response()->json([
                "message" => "Data not found"
            ], 404);
        }
    }

    public function deleteData($id){
        // delete data at id = $id
        if(Energy::where('id', $id)->exists()) {
            $data = Energy::find($id);
            $data->delete();
    
            return response()->json([
              "message" => "Data's records deleted"
            ], 202);
          } 
        else {
            return response()->json([
              "message" => "Data not found"
            ], 404);
        }
    }

    public function getAllFireAlarm(){
        // get all data
        $data = FireAlarm::latest()->get();//->toJson(JSON_PRETTY_PRINT);
        return response($data, 200);
    }

    public function getFireAlarm($id){
        // get data at id = $id
        if (FireAlarm::where('id', $id)->exists()) {
            // $data = FireAlarm::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT); //Variasi bentuk json
            $data = FireAlarm::where('id', $id)->get();
            return response($data, 200);
        } else {
            return response()->json([
                "message" => "Data not found"
            ], 404);
            // abort (404);
        }
    }

    public function updateFireAlarm(Request $request, $id){
        // put data at id = $id
        if (FireAlarm::where('id', $id)->exists()) {
            $data = FireAlarm::find($id);
            $data->status = is_null($request->status) ? $data->status : $request->status;
            $data->save();
    
            return response()->json([
                "message" => "Data's records updated successfully"
            ], 200);
        }
        else {
            return response()->json([
                "message" => "Data not found"
            ], 404);
        }
    }

    //EnergyControl Outlet Master
    public function getAllOutletMaster(){
        
        $data = EnergyOutletMaster::latest()->get()->toJson(JSON_PRETTY_PRINT);
        return response($data, 200);
    }
    public function getOutletMaster($id){
        
        if (EnergyOutletMaster::where('id', $id)->exists()) {
            $data = EnergyOutletMaster::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($data, 200);
        } else {
            return response()->json([
                "message" => "Data not found"
            ], 404);
        }
    }

    public function updateOutletMaster(Request $request, $id){
        // put data at id = $id
        if (EnergyOutletMaster::where('id', $id)->exists()) {
            $data = EnergyOutletMaster::find($id);
            $data->status = is_null($request->status) ? $data->status : $request->status;
            $data->save();
    
            return response()->json([
                "message" => "Data's records updated successfully"
            ], 200);
        }
        else {
            return response()->json([
                "message" => "Data not found"
            ], 404);
        }
    }
    //EnergyControl Panel Master
    public function getAllPanelMaster(){
        
        $data = EnergyPanelMaster::latest()->get()->toJson(JSON_PRETTY_PRINT);
        return response($data, 200);
    }
    public function getPanelMaster($id){
        
        if (EnergyPanelMaster::where('id', $id)->exists()) {
            $data = EnergyPanelMaster::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($data, 200);
        } else {
            return response()->json([
                "message" => "Data not found"
            ], 404);
        }
    }

    public function updatePanelMaster(Request $request, $id){
        // put data at id = $id
        if (EnergyPanelMaster::where('id', $id)->exists()) {
            $data = EnergyPanelMaster::find($id);
            $data->status = is_null($request->status) ? $data->status : $request->status;
            $data->save();
    
            return response()->json([
                "message" => "Data's records updated successfully"
            ], 200);
        }
        else {
            return response()->json([
                "message" => "Data not found"
            ], 404);
        }
    }

    //EnergyControl Outlet 
    public function getAllOutlet(){
        
        $data = EnergyOutlet::latest()->get();//->toJson(JSON_PRETTY_PRINT);
        return response($data, 200);
    }
    public function getOutlet($id){
        
        if (EnergyOutlet::where('id', $id)->exists()) {
            $data = EnergyOutlet::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($data, 200);
        } else {
            return response()->json([
                "message" => "Data not found"
            ], 404);
        }
    }

    public function updateOutlet(Request $request, $id){
        // put data at id = $id
        if (EnergyOutlet::where('id', $id)->exists()) {
            $data = EnergyOutlet::find($id);
            $data->status = is_null($request->status) ? $data->status : $request->status;
            $data->save();
    
            return response()->json([
                "message" => "Data's records updated successfully"
            ], 200);
        }
        else {
            return response()->json([
                "message" => "Data not found"
            ], 404);
        }
    }
    //EnergyControl Panel 
    public function getAllPanel(){
        
        $data = EnergyPanel::latest()->get();//->toJson(JSON_PRETTY_PRINT);
        return response($data, 200);
    }
    public function getPanel($id){
        
        if (EnergyPanel::where('id', $id)->exists()) {
            $data = EnergyPanel::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($data, 200);
        } else {
            return response()->json([
                "message" => "Data not found"
            ], 404);
        }
    }

    public function updatePanel(Request $request, $id){
        // put data at id = $id
        if (EnergyPanel::where('id', $id)->exists()) {
            $data = EnergyPanel::find($id);
            $data->status = is_null($request->status) ? $data->status : $request->status;
            $data->save();
    
            return response()->json([
                "message" => "Data's records updated successfully"
            ], 200);
        }
        else {
            return response()->json([
                "message" => "Data not found"
            ], 404);
        }
    }
    public function getEnergyState(){
        
        $data = EnergyPanel::select('nama','status')->where('nama', '=', 'AC')->pluck('status'); 
        $data2 = EnergyPanel::select('nama','status')->where('nama', '=', 'AC2')->pluck('status');//->toJson(JSON_PRETTY_PRINT);
        $data3 = EnergyPanelMaster::select('nama','status')->oldest()->pluck('status');//latest()->get();//->toJson(JSON_PRETTY_PRINT);
        // $data3 = EnergyOutlet::select('nama','status')->oldest()->pluck('status');//->toJson(JSON_PRETTY_PRINT);
        $data4 = EnergyOutletMaster::select('nama','status')->oldest()->pluck('status');//->toJson(JSON_PRETTY_PRINT);
        return response()->json(['AC1' => $data, 'AC2'=>$data2, 'master'=>$data3 ,'outlet' => $data4,  ]);
        //return response()($data,$data2,$data3,$data4);
    }

    public function energyStatistik(){
        $energiwh = DB::select('SELECT date(energies.created_at)as date,SUM(energies.active_power*(energy_costs.delay/3600)) AS sale FROM energies JOIN energy_costs WHERE id_kwh = 1 GROUP BY date(energies.created_at) DESC');
        return response()->json($energiwh);   
    }

    public function suhulogger(){
        $suhulogger = DhtSensor::select(DhtSensor::raw('created_at as date'), DhtSensor::raw('AVG(temperature) as sale'))->
        groupBy(DhtSensor::raw('created_at'))->
        get();

        return response()->json($suhulogger);    
    }
    public function suhulogger1(){
        $suhulogger = DhtExtraData::where('dht','DHT1')->select(DhtExtraData::raw('created_at as date'), DhtExtraData::raw('AVG(temperature) as sale'))->
        groupBy(DhtExtraData::raw('created_at'))->
        get();

        return response()->json($suhulogger);    
    }
    public function suhulogger2(){
        $suhulogger = DhtExtraData::where('dht','DHT2')->select(DhtExtraData::raw('created_at as date'), DhtExtraData::raw('AVG(temperature) as sale'))->
        groupBy(DhtExtraData::raw('created_at'))->
        get();

        return response()->json($suhulogger);    
    }
    public function suhulogger3(){
        $suhulogger = DhtExtraData::where('dht','DHT3')->select(DhtExtraData::raw('created_at as date'), DhtExtraData::raw('AVG(temperature) as sale'))->
        groupBy(DhtExtraData::raw('created_at'))->
        get();

        return response()->json($suhulogger);    
    }
    public function suhulogger4(){
        $suhulogger = DhtExtraData::where('dht','DHT4')->select(DhtExtraData::raw('created_at as date'), DhtExtraData::raw('AVG(temperature) as sale'))->
        groupBy(DhtExtraData::raw('created_at'))->
        get();

        return response()->json($suhulogger);    
    }
    public function suhulogger5(){
        $suhulogger = DhtExtraData::where('dht','DHT5')->select(DhtExtraData::raw('created_at as date'), DhtExtraData::raw('AVG(temperature) as sale'))->
        groupBy(DhtExtraData::raw('created_at'))->
        get();

        return response()->json($suhulogger);    
    }

    public function humidlogger(){
        $humidlogger = DhtSensor::select(DhtSensor::raw('created_at as date'), DhtSensor::raw('AVG(humidity) as sale'))->
        groupBy(DhtSensor::raw('created_at'))->
        get();

        return response()->json($humidlogger);    
    }
    public function humidlogger1(){
        $humidlogger = DhtExtraData::where('dht','DHT1')->select(DhtExtraData::raw('created_at as date'), DhtExtraData::raw('AVG(humidity) as sale'))->
        groupBy(DhtExtraData::raw('created_at'))->
        get();

        return response()->json($humidlogger);    
    }
    public function humidlogger2(){
        $humidlogger = DhtExtraData::where('dht','DHT2')->select(DhtExtraData::raw('created_at as date'), DhtExtraData::raw('AVG(humidity) as sale'))->
        groupBy(DhtExtraData::raw('created_at'))->
        get();

        return response()->json($humidlogger);    
    }
    public function humidlogger3(){
        $humidlogger = DhtExtraData::where('dht','DHT3')->select(DhtExtraData::raw('created_at as date'), DhtExtraData::raw('AVG(humidity) as sale'))->
        groupBy(DhtExtraData::raw('created_at'))->
        get();

        return response()->json($humidlogger);    
    }
    public function humidlogger4(){
        $humidlogger = DhtExtraData::where('dht','DHT4')->select(DhtExtraData::raw('created_at as date'), DhtExtraData::raw('AVG(humidity) as sale'))->
        groupBy(DhtExtraData::raw('created_at'))->
        get();

        return response()->json($humidlogger);    
    }
    public function humidlogger5(){
        $humidlogger = DhtExtraData::where('dht','DHT5')->select(DhtExtraData::raw('created_at as date'), DhtExtraData::raw('AVG(humidity) as sale'))->
        groupBy(DhtExtraData::raw('created_at'))->
        get();

        return response()->json($humidlogger);    
    }
    

}
