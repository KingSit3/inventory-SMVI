<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index() 
    {
        return view('login');
    }

    public function login(Request $req) 
    {
      $email = $req->input('email');
      $password = $req->input('password');

      // Cek Email
      if (Admin::where('email', $email)->get()->first()) {
        $admin = Admin::where('email', $email)->get()->first();

        // Cek Status Akun ( aktif / non aktif)
        if ($admin['status'] != 0) {

          // Cek Password
          if (Hash::check($password, $admin['password'])) {
            session([
              'login' => 1,
              'name' => $admin['name'],
              'role' => $admin['role'],
              'last_update' => $admin['last_update'],
            ]);

            // Update Last Login
            Admin::where('id', $admin['id'])->update([
              'last_login' => Carbon::now(),
            ]);

            return redirect('/');
          } 
        }
        return redirect()->back()->with('gagal', 'Akun anda tidak aktif!')->withInput();
      }
      return redirect()->back()->with('gagal', 'Password Atau Email Salah!')->withInput();
    }

    public function logout() 
    {
      session()->flush();
      return redirect()->route('login');
    }
}
