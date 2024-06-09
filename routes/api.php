<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorDataController;
use App\Http\Controllers\DoorlockStateController;
use App\Http\Controllers\EnergyController;
use App\Http\Controllers\NodeDataController;
use App\Http\Controllers\StatsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Pengiriman Data diusahakan 3-5 menit sekali
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/* ESP32 (Data Tegangan, Arus, dkk) */
Route::get('get-energies', [NodeDataController::class, 'getEnergyMonitor']); // 300 data energy terakhir untuk debug dan stat
Route::post('add-energies', [NodeDataController::class, 'addEnergyMonitor']); // Input data monitoring
/* Hanya Data 'total_energy' dari Modbus */
Route::get('get-kwh', [NodeDataController::class, 'getTotalEnergy']); // 1000 data 'total_energy' terakhir
Route::post('add-kwh', [NodeDataController::class, 'addTotalEnergy']); // Input 'total_energy' saja 
Route::post('debug-energy', [NodeDataController::class, 'addDebugEnergy']); // untuk debugging semua data energy
Route::get('ike-dummy', [NodeDataController::class, 'getIkeDummy']); // data dummy untuk IKE bulanan
Route::get('ike-dummy-annual', [NodeDataController::class, 'getIkeDummyAnnual']); // data dummy untuk IKE tahunan

/* Energi per Waktu */
Route::get('daily-energy/{id}', [EnergyController::class, 'getDailyEnergy']); // 'total_energy' harian
Route::get('daily-energy-reversed/{id}', [EnergyController::class, 'getDailyEnergyReversed']); // 'total_energy' harian terbalik
Route::get('monthly-energy/{id}', [EnergyController::class, 'getMonthlyEnergy']); // 'total_energy' bulanan
Route::get('annual-energy/{id}', [EnergyController::class, 'getAnnualEnergy']); // 'total_energy' tahunan

/* ESP Control 4 Relay dan DHT */
Route::get('relay-state', [NodeDataController::class, 'getEnergyState']); // Dibaca esp untuk mengubah state Relay Contactor

/* API untuk menampilkan chart di statistics */
Route::get('daily-stat/{id}', [StatsController::class, 'getDailyEnergyStat']); // 'total_energy' harian
Route::get('monthly-stat/{id}', [StatsController::class, 'getMonthlyEnergyStat']); // 'total_energy' bulanan
Route::get('arus-stat/{id}', [StatsController::class, 'getArusStat']);
Route::get('active-stat/{id}', [StatsController::class, 'getActivePowerStat']);


Route::get('energyStat', [NodeDataController::class, 'energyStatistik'])->name('energyStatistik');
Route::get('suhulogger', [NodeDataController::class, 'suhulogger'])->name('suhulogger');
Route::get('humidlogger', [NodeDataController::class, 'humidlogger'])->name('humidlogger');
Route::get('luxlogger', [NodeDataController::class, 'luxlogger'])->name('luxlogger');
Route::get('dailyEnergy/{id}', [NodeDataController::class, 'dailyEnergy'])->name('dailyEnergy');

/* API untuk mencoba function */
Route::get('cek-api', [NodeDataController::class, 'cekApi']);


/* 
    ==============
    API Cadangan
    ==============
*/

// // API SENSOR DHT 
// Route::get('DhtSensor', [SensorDataController::class, 'getDhtExtra'])->name('getDhtExtra');
// Route::post('DhtSensor', [SensorDataController::class, 'postDhtExtra'])->name('postDhtExtra'); // Untuk Sensor DHT Tambahan

// // API FIRE ALARM
// Route::get('FireAlarm', [SensorDataController::class, 'getAllFireAlarm'])->name('getAllFireAlarm');

// // API LAMPU
// Route::get('ApiLight', [SensorDataController::class, 'getLightAll'])->name('getLightAll');

// // API ENERGY
// Route::get('ApiEnergy/{id}', [SensorDataController::class, 'getData']);
// Route::delete('ApiEnergy/{id}', [SensorDataController::class, 'deleteData']);

// // API Energy Devices
// Route::get('OutletMaster', [SensorDataController::class, 'getAllOutletMaster'])->name('getAllOutletMaster');
// Route::get('OutletMaster/{id}', [SensorDataController::class, 'getOutletMaster'])->name('getOutletMaster');
// Route::post('OutletMaster/{id}', [SensorDataController::class, 'updateOutletMaster'])->name('postOutletMaster');
// Route::get('PanelMaster', [SensorDataController::class, 'getAllPanelMaster'])->name('getAllPanelMaster');
// Route::get('PanelMaster/{id}', [SensorDataController::class, 'getPanelMaster'])->name('getPanelMaster');
// Route::post('PanelMaster/{id}', [SensorDataController::class, 'updatePanelMaster'])->name('postPanelMaster');
// Route::get('Outlet', [SensorDataController::class, 'getAllOutlet'])->name('getAllOutlet');
// Route::get('Outlet/{id}', [SensorDataController::class, 'getOutlet'])->name('getOutlet');
// Route::post('Outlet/{id}', [SensorDataController::class, 'updateOutlet'])->name('postOutlet');
// Route::get('Panel', [SensorDataController::class, 'getAllPanel'])->name('getAllPanel');
// Route::get('Panel/{id}', [SensorDataController::class, 'getPanel'])->name('getPanel');
// Route::post('Panel/{id}', [SensorDataController::class, 'updatePanel'])->name('postPanel');

/* 
// Digunakan kalau ada sensor Suhu dan Kelembapan Lagi
Route::get('suhuloggerDHT1', [SensorDataController::class, 'suhulogger1'])->name('suhulogger1');
Route::get('suhulogger2', [SensorDataController::class, 'suhulogger2'])->name('suhulogger2');
Route::get('suhulogger3', [SensorDataController::class, 'suhulogger3'])->name('suhulogger3');
Route::get('suhulogger4', [SensorDataController::class, 'suhulogger4'])->name('suhulogger4');
Route::get('suhulogger5', [SensorDataController::class, 'suhulogger5'])->name('suhulogger5');

Route::get('humidlogger1', [SensorDataController::class, 'humidlogger1'])->name('humidlogger1');
Route::get('humidlogger2', [SensorDataController::class, 'humidlogger2'])->name('humidlogger2');
Route::get('humidlogger3', [SensorDataController::class, 'humidlogger3'])->name('humidlogger3');
Route::get('humidlogger4', [SensorDataController::class, 'humidlogger4'])->name('humidlogger4');
Route::get('humidlogger5', [SensorDataController::class, 'humidlogger5'])->name('humidlogger5');
 */