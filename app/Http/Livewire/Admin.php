<?php

namespace App\Http\Livewire;

use App\Models\ModelAdmin as ModelsAdmin;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Admin extends Component
{
    public $nama, $password, $email, $status, $role, $adminId;
    public $submitType= '';
    public $isOpen = false;

    public function render()
    {
        
        $data = [
            'admin' => ModelsAdmin::paginate(10),
        ];  

        return view('livewire.admin', $data)
        ->extends('layouts.app');
    }

    public function add() 
    {
        $this->submitType = 'tambah';
    }

    public function tambah() 
    {
        $this->validate(
            // Rules
            [
                'nama' => 'required',
                'email' => 'unique:App\Models\Admin,email',
            ]
        );

        // Save data
        ModelsAdmin::create([
            'nama' => $this->nama,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => $this->role,
            'status' => $this->status,
            'last_login' => Carbon::now(),
        ]);
        
        // Panggil fungsi Reset data
        $this->resetData();

        // Tutup Modal
        $this->isOpen = false;

        // Panggil SweetAlert berhasil
        $this->emit('success', 'Data Admin Berhasil Ditambahkan');
    }

    public function edit($id) 
    {
      $adminDb = ModelsAdmin::where('id', $id)->first();

      $this->submitType = 'update';
      $this->adminId = $id;
      $this->nama = $adminDb['nama'];
      $this->email = $adminDb['email'];
      $this->role = $adminDb['role'];
      $this->status = $adminDb['status'];
    }

    public function update() 
    {
        $this->validate(
            // Rules
            [
                'nama' => 'required',
            ]
        );
        
        //Kalau password kosong
        if ($this->password == null) {
            ModelsAdmin::where('id', $this->adminId)->update([
                'nama' => $this->nama,
                'role' => $this->role,
                'status' => $this->status,
            ]);
        } else {
            ModelsAdmin::where('id', $this->adminId)->update([
                'nama' => $this->nama,
                'password' => Hash::make($this->password),
                'role' => $this->role,
                'status' => $this->status,
            ]);
        }

        $this->resetData();

        // Tutup Modal
        $this->isOpen = false;

        // Panggil SweetAlert berhasil
        $this->emit('success', 'Data Admin Berhasil Diubah');

    }

    public function resetData() 
    {
        // Reset Validasi
        $this->resetValidation();
        // Reset input field
        $this->reset();
    }
}
