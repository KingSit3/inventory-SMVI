<?php

namespace App\Http\Livewire\User;

use App\Models\LogUser;
use App\Models\User;
use Exception;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    public $userId, $nik, $name, $no_telp, $userData, $oldUserData;
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
        // Validasi
        $this->validate(
            // Rules
            [
                'nik' => 'unique:App\Models\User,nik|numeric|nullable',
                'name' => 'required',
                'no_telp' => 'nullable',
            ]
        );

        User::create([
            'name' => $this->name,
            'nik' => $this->nik,
            'no_telp' => $this->no_telp,
        ]);

        $dataUser = User::latest()->first();
        LogUser::create([
            'id_user' => $dataUser['id'],
            'data_log' => [
                            'aksi' => 'Tambah',
                            'browser' => $_SERVER['HTTP_USER_AGENT'],
                            'edited_by' => session('name'),
                            'data_lama' =>  [],
                            'data_baru' =>  [
                                                'name' => $this->name,
                                                'nik' => $this->nik,
                                                'no_telp' => $this->no_telp,
                                            ],
                            ],
            ]);
        
        // Panggil fungsi Reset data
        $this->resetData();

        // Tutup Modal
        $this->isOpen = false;

        // Panggil SweetAlert berhasil
        $this->emit('success', 'Data User Berhasil Ditambahkan');
    }

    public function delete($id)
    {
      $userQuery = User::where(['id' => $id])->first();
      $userQuery->delete();

      LogUser::create([
        'id_user' => $id,
        'data_log' => [
                        'aksi' => 'Hapus',
                        'browser' => $_SERVER['HTTP_USER_AGENT'],
                        'edited_by' => session('name'),
                        'data_lama' =>  [
                                            'name' => $userQuery['name'],
                                            'nik' => $userQuery['nik'],
                                            'no_telp' => $userQuery['no_telp'],
                                        ],
                        'data_baru' =>  [],
                        ],
        ]);
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

        $this->oldUserData = User::where('id', $id)->first();
    }

    public function update()
    {
            $this->validate(
                // Rules
                [
                    // Gagal validasi unique
                    'nik' => ['numeric', 'nullable', Rule::unique('users', 'nik')->ignore($this->nik, 'nik')],
                    'name' => 'required',
                    'no_telp' => 'nullable',
                ]
            );

        // Pakai fitur Try Catch Untuk mengatasi eror unique
        try {
            User::where('id', $this->userId)->update([
                'nik' => $this->nik,
                'name' => $this->name,
                'no_telp' => $this->no_telp,
            ]);

            LogUser::create([
                'id_user' => $this->userId,
                'data_log' => [
                                'aksi' => 'Edit',
                                'browser' => $_SERVER['HTTP_USER_AGENT'],
                                'edited_by' => session('name'),
                                'data_lama' =>  [
                                                    'name' => $this->oldUserData['name'],
                                                    'nik' => $this->oldUserData['nik'],
                                                    'no_telp' => $this->oldUserData['no_telp'],
                                                ],
                                'data_baru' =>  [
                                                    'name' => $this->name,
                                                    'nik' => $this->nik,
                                                    'no_telp' => $this->no_telp,
                                                ],
                                ],
                ]);
        } catch (\Exception $ex) {
            return $this->addError('nik', 'NIK Sudah Terdaftar');
        }

        // Panggil fungsi Reset data
        $this->resetData();

        // Tutup Modal
        $this->isOpen = false;

        // Panggil SweetAlert berhasil
        $this->emit('success', 'Data User Berhasil Diubah');
    }

    public function resetData() 
    {
        // Reset Validasi
        $this->resetValidation();
        // Reset input field
        $this->reset();
    }
}
