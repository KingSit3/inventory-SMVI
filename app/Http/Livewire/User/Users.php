<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    public $userId, $nik, $name, $no_telp, $userData;
    public $submitType = '';
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
        // Panggil fungsi Reset data
        $this->submitType = 'tambah';

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

        // Save data
        User::create([
            'name' => $this->name,
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
        if ($this->nik == null) {
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
                    'nik' => [
                        'numeric',
                        Rule::unique('users')->ignore($this->nik, 'nik'),
                    ],
                    'name' => 'required',
                    'no_telp' => $noValidation,
                ],
                $message
            );
        }

        // Save data
        // $dataUser = User::findOrFail($this->userId);
        // $dataUser->name = $this->name;
        // $dataUser->nik = $this->nik;
        // $dataUser->no_telp = $this->no_telp;
        // $dataUser->save();

        User::where('id', $this->userId)->update([
            'nik' => $this->nik,
            'name' => $this->name,
            'no_telp' => $this->no_telp,
        ]);
        
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
