<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\JadwalAbsenController;
use Illuminate\Support\Facades\Route;



Route::resource('/', 'loginController');
Route::resource('/proses/login/user', 'loginController');
Route::resource('/new/account', 'registerController');
Route::resource('/proses/new/akun/user', 'registerController');
Route::resource('/dashboard', 'dashboardController');
Route::resource('/new/service/add', 'serviceController');
Route::get('/detail/service', 'serviceController@detailservice');
Route::get('/proses/new/service', 'serviceController@prosesNewService');
Route::get('/delete/data/service/id/{id_service}', 'serviceController@deleteService');
Route::get('/update/data/service/id/{id_service}', 'serviceController@updateService');
Route::get('/proses/update/service/id/{id_service}', 'serviceController@prosesUpdateService');

Route::get('/logout/user', function () {
    session()->forget('id');
    return redirect('/');
});



Route::resource('/jadwal-absen', JadwalAbsenController::class);
Route::resource('/department', DepartmentController::class);

