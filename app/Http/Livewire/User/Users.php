<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class Users extends Component
{
    use WithPagination;

    public $userId, $nik, $name, $no_telp, $userData;
    public $submitType, $keyword = '';
    public $isOpen = false;

    // Method dari Livewire untuk reset filter saat pagination
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $keyword = '%'.$this->keyword.'%';
        
        $data = [
            'users' => User::where('name', 'like', $keyword)
                        ->orWhere('nik', 'like', $keyword)
                        ->paginate(10),
        ];

        return view('livewire.user.users', $data)
        ->extends('layouts.app');
    }

    public function add()
    {
        $this->submitType = 'tambah';
    }

    public function tambah()
    {
        // Jika nik == null maka jangan pakai validation unique
        if ($this->nik === null) {
            $nikValidation = '';
        } else {
            $nikValidation = 'unique:App\Models\User,nik|numeric';
        }

        if ($this->no_telp === null) {
            $noValidation = '';
        } else {
            $noValidation = 'numeric';
        }

        // Validasi
        $this->validate(
            // Rules
            [
                'nik' => $nikValidation,
                'name' => 'required',
                'no_telp' => $noValidation,
            ],
            // Message
            [
                'nik.unique' => 'Nik sudah ada',
                'nik.numeric' => 'Harus berupa nomor',
                'name.required' => 'Nama harus diisi',
                'no_telp.numeric' => 'Harus berupa nomor',
            ]
        );

        // $newNik = ;

        // Save data
        User::create([
            'name' => Str::title($this->name),
            'nik' => $this->nik,
            'no_telp' => $this->no_telp,
        ]);
        
        // Panggil fungsi Reset data
        $this->resetData();

        // Tutup Modal
        $this->isOpen = false;

        // Panggil SweetAlert berhasil
        $this->emit('success', 'Data Berhasil Ditambahkan');
    }

    public function delete($id)
    {
      User::where(['id' => $id])->delete();
    }

    public function edit($id) 
    {
        $this->submitType = 'update';
        $this->userData = User::where('id', $id)->first();

        // Masukkan value
        $this->userId = $id;
        $this->nik = $this->userData['nik'];
        $this->name = $this->userData['name'];
        $this->no_telp = $this->userData['no_telp'];
    }

    public function update()
    {

        $message = [
            'nik.unique' => 'Nik sudah ada',
            'nik.numeric' => 'Harus berupa nomor',
            'name.required' => 'Nama harus diisi',
            'no_telp.numeric' => 'Harus berupa nomor',
        ];

        if ($this->no_telp === null) {
            $noValidation = '';
        } else {
            $noValidation = 'numeric';
        }

        // Jika nik == null maka jangan pakai validation unique
        if ($this->nik === null) {
            $this->validate(
                // Rules
                [
                    'name' => 'required',
                    'no_telp' => $noValidation,
                ],
                $message
            );
        } else {
            $this->validate(
                // Rules
                [
                    // Gagal validasi unique
                    'nik' => ['numeric', Rule::unique('users', 'nik')->ignore($this->nik, 'nik')],
                    'name' => 'required',
                    'no_telp' => $noValidation,
                ],
                $message
            );
        }

        // Pakai fitur Try Catch Untuk mengatasi eror unique
        try {
            User::where('id', $this->userId)->update([
                'nik' => $this->nik,
                'name' => $this->name,
                'no_telp' => $this->no_telp,
            ]);
        } catch (\Exception $ex) {
            return $this->addError('nik', 'NIK Sudah Terdaftar');
        }

        
        
        // Panggil fungsi Reset data
        $this->resetData();

        // Tutup Modal
        $this->isOpen = false;

        // Panggil SweetAlert berhasil
        $this->emit('success', 'Data Berhasil Diubah');
    }

    public function resetData() 
    {
        // Reset Validasi
        $this->resetValidation();
        // Reset input field
        $this->reset('name', 'nik', 'no_telp', 'submitType', 'userData', 'userId');
    }
}
