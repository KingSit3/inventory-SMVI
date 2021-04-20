<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\LoginController;
use App\Http\Livewire\Admin;
use App\Http\Livewire\DeliveryOrder\DeletedDeliveryOrder;
use App\Http\Livewire\DeliveryOrder\DeliveryOrder;
use App\Http\Livewire\DeliveryOrder\DeliveryOrderInfo;
use App\Http\Livewire\Perangkat\DeletedImage;
use App\Http\Livewire\Perangkat\DeletedPerangkat;
use App\Http\Livewire\Perangkat\Tipe;
use App\Http\Livewire\Perangkat\DeletedTipe;
use App\Http\Livewire\User\Users;
use App\Http\Livewire\User\DeletedUsers;
use App\Http\Livewire\Perangkat\Image;
use App\Http\Livewire\Perangkat\Perangkat;
use App\Http\Livewire\User\Info;
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
    Route::get('/print',function(){
        $pdf = PDF::loadView('printDo');
        return $pdf->download('printDo.pdf');
    });
    Route::get('/', [Dashboard::class, 'index'])->name('dashboard');
    Route::get('/logout', [LoginController::class, 'logout']);

    Route::get('/perangkat', Perangkat::class);
    Route::get('/deletedperangkat', DeletedPerangkat::class);

    Route::get('/deliveryorder', DeliveryOrder::class);
    Route::get('/deleteddeliveryorder', DeletedDeliveryOrder::class);
    Route::get('/do/{id}', DeliveryOrderInfo::class);

    Route::get('/users', Users::class);
    Route::get('/user/{id}', Info::class);
    Route::get('/deletedusers', DeletedUsers::class);

    Route::get('/tipe', Tipe::class);
    Route::get('/deletedtipe', DeletedTipe::class);

    Route::get('/image', Image::class);
    Route::get('/deletedimage', DeletedImage::class);

    Route::get('/witel', Witel::class);
    Route::get('/deletedwitel', DeletedWitel::class);
    
    Route::get('/admin', Admin::class);
});

// Kalau Selain super admin tidak boleh kesini
Route::middleware('selainSuperAdmin')->group(function(){
    Route::get('/admin', Admin::class);
});





