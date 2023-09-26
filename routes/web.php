<?php

use App\Http\Controllers\JadwalAbsenController;
use App\Http\Controllers\loginController;
use Illuminate\Support\Facades\Route;



Route::resource('/', 'loginController');
Route::resource('/proses/login/user', 'loginController');
Route::resource('/new/account', 'registerController');
Route::resource('/proses/new/akun/user', 'registerController');
Route::resource('/dashboard', 'dashboardController');
Route::get('/logout/user', function () {
    session()->forget('id');
    return redirect('/');
});



Route::resource('/jadwal-absen', JadwalAbsenController::class);
