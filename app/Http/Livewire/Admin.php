<?php

namespace App\Http\Livewire;

use App\Models\Admin as ModelsAdmin;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Admin extends Component
{
    public $nama, $password, $email;
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
            ],
            // Message
            [
                'nama.required' => 'Nama Harus diisi',
                'email.unique' => 'Email Sudah ada',
            ]
        );

        // Save data
        ModelsAdmin::create([
            'name' => $this->nama,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => 1,
            'status' => 1,
            'last_login' => Carbon::now(),
        ]);
        
        // Panggil fungsi Reset data
        $this->resetData();

        // Tutup Modal
        $this->isOpen = false;

        // Panggil SweetAlert berhasil
        $this->emit('success', 'Data Admin Berhasil Ditambahkan');
    }

    public function resetData() 
    {
        // Reset Validasi
        $this->resetValidation();
        // Reset input field
        $this->reset('nama', 'password', 'email', 'submitType');
    }
}
