<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PrintPengiriman;
use App\Http\Livewire\Admin;
use App\Http\Livewire\Pengiriman\DeletedPengiriman;
use App\Http\Livewire\Pengiriman\Pengiriman;
use App\Http\Livewire\Pengiriman\PengirimanInfo;
use App\Http\Livewire\Log\InfoLogPengiriman;
use App\Http\Livewire\Log\InfoLogTipeSistem;
use App\Http\Livewire\Log\InfoLogPerangkat;
use App\Http\Livewire\Log\InfoLogTipe;
use App\Http\Livewire\Log\InfoLogUser;
use App\Http\Livewire\Log\InfoLogCabang;
use App\Http\Livewire\Log\LogTipeSistem;
use App\Http\Livewire\Log\LogPerangkat;
use App\Http\Livewire\Log\LogTipePerangkat;
use App\Http\Livewire\Log\LogUser;
use App\Http\Livewire\Log\LogCabang;
use App\Http\Livewire\Perangkat\DeletedTipeSistem;
use App\Http\Livewire\Perangkat\DeletedPerangkat;
use App\Http\Livewire\Perangkat\Tipe;
use App\Http\Livewire\Perangkat\DeletedTipe;
use App\Http\Livewire\User\Users;
use App\Http\Livewire\User\DeletedUsers;
use App\Http\Livewire\Perangkat\TipeSistem;
use App\Http\Livewire\Perangkat\InfoTipeSistem;
use App\Http\Livewire\Perangkat\InfoPerangkat;
use App\Http\Livewire\Perangkat\InfoGelombang;
use App\Http\Livewire\Perangkat\InfoTipe;
use App\Http\Livewire\Perangkat\Perangkat;
use App\Http\Livewire\Perangkat\Gelombang;
use App\Http\Livewire\User\InfoUser;
use App\Http\Livewire\cabang\Cabang;
use App\Http\Livewire\cabang\DeletedCabang;
use App\Http\Livewire\cabang\InfoCabang;
use App\Http\Livewire\Log\LogPengiriman;

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

    Route::get('/perangkat', Perangkat::class);
    Route::get('/deletedperangkat', DeletedPerangkat::class);
    Route::get('/infoperangkat/{id}', InfoPerangkat::class);

    Route::get('/pengiriman', Pengiriman::class);
    Route::get('/deletedpengiriman', DeletedPengiriman::class);
    Route::get('/pengiriman/{id}', PengirimanInfo::class);
    Route::get('/printpengiriman/{id}', [PrintPengiriman::class, 'index']);

    Route::get('/users', Users::class);
    Route::get('/user/{id}', InfoUser::class);
    Route::get('/deletedusers', DeletedUsers::class);

    Route::get('/tipe', Tipe::class);
    Route::get('/tipe/{id}', InfoTipe::class);
    Route::get('/deletedtipe', DeletedTipe::class);

    Route::get('/tipesistem', TipeSistem::class);
    Route::get('/tipesistem/{id}', InfoTipeSistem::class);
    Route::get('/deletedtipesistem', DeletedTipeSistem::class);

    Route::get('/gelombang', Gelombang::class);
    Route::get('/gelombang/{nama}', InfoGelombang::class);

    Route::get('/cabang', Cabang::class);
    Route::get('/cabang/{id}', InfoCabang::class);
    Route::get('/deletedcabang', DeletedCabang::class);

    // Log Route
    Route::get('/logtipesistem', LogTipeSistem::class);
    Route::get('/logtipesistem/{id}', InfoLogTipeSistem::class);
    Route::get('/logtipeperangkat', LogTipePerangkat::class);
    Route::get('/logtipeperangkat/{id}', InfoLogTipe::class);
    Route::get('/logpengiriman', LogPengiriman::class);
    Route::get('/logpengiriman/{id}', InfoLogPengiriman::class);
    Route::get('/logcabang', LogCabang::class);
    Route::get('/logcabang/{id}', InfoLogCabang::class);
    Route::get('/loguser', LogUser::class);
    Route::get('/loguser/{id}', InfoLogUser::class);
    Route::get('/logperangkat', LogPerangkat::class);
    Route::get('/logperangkat/{id}', InfoLogPerangkat::class);
    
    Route::get('/admin', Admin::class);
});

// Kalau Selain super admin tidak boleh kesini
Route::middleware('selainSuperAdmin')->group(function(){
    Route::get('/admin', Admin::class);
});





