<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard;
use App\Http\Livewire\Perangkat\DeletedImage;
use App\Http\Livewire\Perangkat\Tipe;
use App\Http\Livewire\Perangkat\DeletedTipe;
use App\Http\Livewire\User\Users;
use App\Http\Livewire\User\DeletedUsers;
use App\Http\Livewire\Perangkat\Image;

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

Route::get('/', [Dashboard::class, 'index']);
Route::get('/users', Users::class);
Route::get('/deletedusers', DeletedUsers::class);
Route::get('/tipe', Tipe::class);
Route::get('/deletedtipe', DeletedTipe::class);
Route::get('/image', Image::class);
Route::get('/deletedimage', DeletedImage::class);
