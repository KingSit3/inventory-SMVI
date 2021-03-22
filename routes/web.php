<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\LoginController;
use App\Http\Livewire\Admin;
use App\Http\Livewire\Perangkat\DeletedImage;
use App\Http\Livewire\Perangkat\Tipe;
use App\Http\Livewire\Perangkat\DeletedTipe;
use App\Http\Livewire\User\Users;
use App\Http\Livewire\User\DeletedUsers;
use App\Http\Livewire\Perangkat\Image;
use App\Http\Livewire\Witel\Witel;
use App\Http\Livewire\Witel\DeletedWitel;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Kalau sudah login, tidak boleh kesini
Route::middleware('isLogin')->group(function(){
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/auth', [LoginController::class, 'login']);
});

// Kalau Belum login, tidak boleh kesini
Route::middleware('login')->group(function(){
    Route::get('/', [Dashboard::class, 'index'])->name('dashboard');
    Route::get('/logout', [LoginController::class, 'logout']);
    Route::get('/users', Users::class);
    Route::get('/deletedusers', DeletedUsers::class);
    Route::get('/tipe', Tipe::class);
    Route::get('/deletedtipe', DeletedTipe::class);
    Route::get('/image', Image::class);
    Route::get('/deletedimage', DeletedImage::class);
    Route::get('/witel', Witel::class);
    Route::get('/deletedwitel', DeletedWitel::class);
    Route::get('/admin', Admin::class);
});

// Kalau admin tidak boleh kesini
Route::middleware('admin')->group(function(){
    Route::get('/admin', Admin::class);
});

// Kalau Staff tidak boleh kesini
Route::middleware('admin')->group(function(){
    Route::get('/admin', Admin::class);
});




