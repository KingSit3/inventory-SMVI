<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PrintDo;
use App\Http\Livewire\Admin;
use App\Http\Livewire\DeliveryOrder\DeletedDeliveryOrder;
use App\Http\Livewire\DeliveryOrder\DeliveryOrder;
use App\Http\Livewire\DeliveryOrder\DeliveryOrderInfo;
use App\Http\Livewire\Log\InfoLogDeliveryOrder;
use App\Http\Livewire\Log\InfoLogImage;
use App\Http\Livewire\Log\InfoLogTipe;
use App\Http\Livewire\Log\InfoLogUser;
use App\Http\Livewire\Log\InfoLogWitel;
use App\Http\Livewire\Log\LogDeliveryOrder;
use App\Http\Livewire\Log\LogImage;
use App\Http\Livewire\Log\LogTipePerangkat;
use App\Http\Livewire\Log\LogUser;
use App\Http\Livewire\Log\LogWitel;
use App\Http\Livewire\Perangkat\DeletedImage;
use App\Http\Livewire\Perangkat\DeletedPerangkat;
use App\Http\Livewire\Perangkat\Tipe;
use App\Http\Livewire\Perangkat\DeletedTipe;
use App\Http\Livewire\User\Users;
use App\Http\Livewire\User\DeletedUsers;
use App\Http\Livewire\Perangkat\Image;
use App\Http\Livewire\Perangkat\InfoImage;
use App\Http\Livewire\Perangkat\InfoPerangkat;
use App\Http\Livewire\Perangkat\InfoSp;
use App\Http\Livewire\Perangkat\InfoTipe;
use App\Http\Livewire\Perangkat\Perangkat;
use App\Http\Livewire\Perangkat\SP;
use App\Http\Livewire\User\InfoUser;
use App\Http\Livewire\Witel\Witel;
use App\Http\Livewire\Witel\DeletedWitel;
use App\Http\Livewire\Witel\InfoWitel;

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

    Route::get('/deliveryorder', DeliveryOrder::class);
    Route::get('/deleteddeliveryorder', DeletedDeliveryOrder::class);
    Route::get('/do/{id}', DeliveryOrderInfo::class);
    Route::get('/printdo/{id}', [PrintDo::class, 'index']);

    Route::get('/users', Users::class);
    Route::get('/user/{id}', InfoUser::class);
    Route::get('/deletedusers', DeletedUsers::class);

    Route::get('/tipe', Tipe::class);
    Route::get('/tipe/{id}', InfoTipe::class);
    Route::get('/deletedtipe', DeletedTipe::class);

    Route::get('/image', Image::class);
    Route::get('/image/{id}', InfoImage::class);
    Route::get('/deletedimage', DeletedImage::class);

    Route::get('/sp', SP::class);
    Route::get('/sp/{id}', InfoSp::class);

    Route::get('/witel', Witel::class);
    Route::get('/witel/{id}', InfoWitel::class);
    Route::get('/deletedwitel', DeletedWitel::class);

    // Log Route
    Route::get('/logimage', LogImage::class);
    Route::get('/logimage/{id}', InfoLogImage::class);
    Route::get('/logtipeperangkat', LogTipePerangkat::class);
    Route::get('/logtipeperangkat/{id}', InfoLogTipe::class);
    Route::get('/logdeliveryorder', LogDeliveryOrder::class);
    Route::get('/logdeliveryorder/{id}', InfoLogDeliveryOrder::class);
    Route::get('/logwitel', LogWitel::class);
    Route::get('/logwitel/{id}', InfoLogWitel::class);
    Route::get('/loguser', LogUser::class);
    Route::get('/loguser/{id}', InfoLogUser::class);
    
    Route::get('/admin', Admin::class);
});

// Kalau Selain super admin tidak boleh kesini
Route::middleware('selainSuperAdmin')->group(function(){
    Route::get('/admin', Admin::class);
});





