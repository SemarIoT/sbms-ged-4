<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\EnergyController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\EnergyPanelController;

/* Diurutkat sesuai SIDEBAR */


//digunakan untuk mengatur hal hal yang berkaitan dengan halaman dashbooards (landing page tanpa login)
Route::get('/', [PagesController::class, 'noAuth']);

Route::get('/login', function () {
    return view('auth.login');
});
//digunakan untuk mengatur hal hal yang berkaitan dengan halaman dashboard (setelah login)
Route::get('/dashboard', [PagesController::class, 'wasLogin']);

//digunakan untuk mengatur hal hal yang berkaitan dengan halaman energy monitoring
Route::get('/monitor', [EnergyController::class, 'monitor']);
Route::get('/control', [EnergyController::class, 'control']);
Route::get('/statistic', [EnergyController::class, 'stats']);
Route::get('/control-change-status-panel/{id}', [EnergyPanelController::class, 'changePanel']);
// Route::get('/control-change-status-panel-master/{id}', [EnergyController::class, 'changePanelMaster']);

Route::get('/energyexportxlxs', [EnergyController::class, 'export_excel']);
Route::get('/energyexportcsv', [EnergyController::class, 'export_excel_csv']);

//digunakan untuk mengatur hal hal yang berkaitan dengan halaman about
Route::get('/about', [AboutController::class, 'index']);
Route::get('/aboutedit/{id}', [AboutController::class, 'aboutedit'])->name('aboutedit');
Route::post('aboutupdate', [AboutController::class, 'aboutupdate'])->name('aboutupdate');

//Profil page -> digunakan untuk mengatur hal hal yang berkaitan dengan halaman profile
Route::get('/changePassword', [AuthController::class, 'showChangePasswordForm'])->name('changePassword');
Route::post('/changePassword', [AuthController::class, 'changePassword'])->name('changePassword');
Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
Route::get('showprofile/{id}', [AuthController::class, 'showprofile'])->name('showprofile');
Route::post('updateprofile', [AuthController::class, 'updateprofile'])->name('updateprofile');

// ======== ADMIN PAGE =========
//digunakan untuk mengatur hal hal yang berkaitan dengan halaman daftar hak akses (admin, user, developer)
Route::resource('daftar-admin', \App\Http\Controllers\AdminListController::class);
Route::post('/addUser', [App\Http\Controllers\AdminListController::class, 'storeUser'])->name('addUser');
Route::post('updateUser', [App\Http\Controllers\AdminListController::class, 'updateUser'])->name('updateUser');
Route::get('showUser/{id}', [App\Http\Controllers\AdminListController::class, 'showUser']);
Route::get('deleteUser/{id}', [App\Http\Controllers\AdminListController::class, 'delete']);
Route::get('/daftar-admin-create', function () {
    return view('admin.create');
});
Route::get('/daftar-admin-edit/{id}', [App\Http\Controllers\AdminListController::class, 'editUser'])->name('editUser')->middleware('auth');

//digunakan untuk mengatur hal hal yang berkaitan dengan halaman pengaturan (ubah harga, dan fitur2 lainya di halaman setting)
Route::get('setting-admin', [SettingController::class, 'index']);
Route::get('setting-ubah-harga-energy-admin/{id}', [SettingController::class, 'editHarga'])->name('editHarga');
Route::post('settingupdatehargaenergyadmin', [SettingController::class, 'updateHarga'])->name('updateHarga');
Route::get('setting_dhtexportxlxs', [SettingController::class, 'Dht_export_excel']);
Route::get('setting_dhtexportcsv', [SettingController::class, 'Dht_export_excel_csv']);
Route::get('truncateDataDht', [SettingController::class, 'truncateDataDht']);
Route::get('setting_energyexportxlxs', [SettingController::class, 'Energy_export_excel']);
Route::get('setting_energyexportcsv', [SettingController::class, 'Energy_export_excel_csv']);
Route::get('truncateDataEnergy', [SettingController::class, 'truncateDataEnergy']);
Route::get('ubahstatusdashboard/{id}', [SettingController::class, 'ubahstatusdashboard']);


//panel//digunakan untuk mengatur hal hal yang berkaitan dengan halaman daftar sensor - daftar panel
Route::post('/storePanelList', [EnergyController::class, 'storePanelList'])->name('storePanelList');
Route::post('updatePanelList', [EnergyController::class, 'updatePanelList'])->name('updatePanelList');
Route::get('showPanelList/{id}', [EnergyController::class, 'showPanelList']);
Route::get('deletePanelList/{id}', [EnergyController::class, 'deletePanelList']);
Route::get('/daftar-Panel-create', function () {
    return view('admin.sensor.panelcreate');
});
Route::get('/daftar-Panel-edit/{id}', [EnergyController::class, 'editPanelList'])->name('editPanelList')->middleware('auth');
Route::get('showPanelMasterList/{id}', [EnergyController::class, 'showPanelMasterList']);


//login multi level user-proses autentikasi login
Route::get('/login', [AuthController::class, 'index'])->name('login');
// Route::get('register', 'App\Http\Controllers\AuthController@register')->name('register');
Route::post('/proses_login', [AuthController::class, 'proses_login'])->name('proses_login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Route::group(['middleware' => ['auth']], function () {
//     Route::group(['middleware' => ['cek_login:admin']], function () {
//         Route::resource('admin', \App\Http\Controllers\DashboardController::class);
//     });
//     Route::group(['middleware' => ['cek_login:editor']], function () {
//         Route::resource('editor', \App\Http\Controllers\DashboardController::class);
//     });
// });
