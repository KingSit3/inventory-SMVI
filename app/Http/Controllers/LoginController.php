<?php

namespace App\Http\Controllers;

use App\Models\ModelPengguna as Admin;
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
              'nama' => $admin['nama'],
              'role' => $admin['role'],
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
