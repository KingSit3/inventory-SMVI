<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    public $nik = null;
    public $name = null;
    public $no_telp = null;
    public $isOpen = false;

    public function render()
    {
        $data = [
            'users' => User::paginate(10),
        ];

        return view('livewire.user.users', $data)
        ->extends('layouts.app');
    }

    public function tambah()
    {
        // Jika nik == null maka jangan pakai validation unique
        if ($this->nik === null) {
            $nikValidation = 'numeric';
        } else {
            $nikValidation = 'unique:App\Models\User,nik|numeric';
        }

        // Validasi
        $this->validate(
            // Rules
            [
                'nik' => $nikValidation,
                'name' => 'required',
                'no_telp' => 'numeric',
            ],
            // Message
            [
                'nik.unique' => 'Nik sudah ada',
                'nik.numeric' => 'Harus berupa nomor',
                'name.required' => 'Nama harus diisi',
                'no_telp.numeric' => 'Harus berupa nomor',
            ]
        );

        // Save data
        User::create([
            'name' => $this->name,
            'nik' => $this->nik,
            'no_telp' => $this->no_telp,
        ]);
        
        // Reset data
        $this->reset('name', 'nik', 'no_telp');

        // Tutup Modal
        $this->isOpen = false;
    }
}
