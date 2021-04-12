<?php

namespace App\Http\Livewire\Perangkat;

use App\Models\DoModel;
use App\Models\Image;
use App\Models\Perangkat as ModelsPerangkat;
use App\Models\SP;
use App\Models\tipePerangkat;
use App\Models\User;
use App\Models\Witel;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Perangkat extends Component
{ 
    use WithPagination;
    public $tipePerangkat, $sn_lama, $sn_pengganti, $sn_monitor, $imagePerangkat, $cekStatus, $perolehan, $spPerangkat, $ket;
    public $dbPerangkat, $perangkatId, $dbWitel, $dbUser;
    public $namaUser, $nikUser, $telpUser, $userSearch, $userId;
    public $witel, $witelSearch, $witelKode;
    public $kodeDo, $doId, $doSearch;

    public $submitType, $keyword = '';
    public $isOpen, $addUser = false;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $keyword = '%'.$this->keyword.'%';

        $hasilUser = '';
        if (strlen($this->userSearch) > 0) {
            $this->addUser = false;
            $userSearchQuery = '%'.$this->userSearch.'%';
            $hasilUser = User::where('name', 'like', $userSearchQuery)->limit(5)->get();
        }

        $hasilWitel = '';
        if (strlen($this->witelSearch) > 0) {
            $witelSearchQuery = '%'.$this->witelSearch.'%';
            $hasilWitel = Witel::where('nama_witel', 'like', $witelSearchQuery)->limit(5)->get();
        }

        $hasilDo = '';
        if (strlen($this->doSearch) > 0) {
            $doSearchQuery = '%'.$this->doSearch.'%';
            $hasilDo = DoModel::where('no_do', 'like', $doSearchQuery)->limit(5)->get();
        }

        $data = [
            'doResult' => $hasilDo,
            'userResult' => $hasilUser,
            'witelResult' => $hasilWitel,
            'sp' => SP::all()->sortDesc(),
            'image' => Image::all(),
            'tipe' => tipePerangkat::all(),
            'perangkatData' => ModelsPerangkat::with(['Users', 'Witel'])
                            ->where('sn_pengganti', 'like', $keyword)
                            ->paginate(10),
        ];

        return view('livewire.perangkat.perangkat', $data)
        ->extends('layouts.app');
    }

    public function add() 
    {
        $this->submitType = 'tambah';
    }

    public function tambah() 
    {
        if ($this->addUser == true) {
            $nikValidate = ['nullable', 'numeric', Rule::unique('users', 'nik')->ignore($this->nikUser, 'nik')];
        } else {
            $nikValidate = '';
        }

        $this->validate([
            'sn_lama' => 'unique:App\Models\Perangkat,sn_lama|nullable',
            'tipePerangkat' => 'required',
            'sn_pengganti' => 'unique:App\Models\Perangkat,sn_pengganti',
            'sn_monitor' => 'unique:App\Models\Perangkat,sn_monitor|nullable',
            'nikUser' => $nikValidate,
            'imagePerangkat' => 'required',
        ]);

        if ($this->addUser == true) {
            // Jika tambah user
            try {
                User::create([
                'name' => $this->namaUser,
                'nik' => $this->nikUser,
                'no_telp' => $this->telpUser,
                ]);

            // Ambil id user terakhir
            $getLastUser = User::get()->last();
            $this->userId = $getLastUser['id'];

                ModelsPerangkat::create([
                    'sn_lama' => $this->sn_lama,
                    'tipe_perangkat' => $this->tipePerangkat,
                    'sn_pengganti' => $this->sn_pengganti,
                    'sn_monitor' => $this->sn_monitor,
                    'id_user' => $this->userId,
                    'kode_image' => $this->imagePerangkat,
                    'kode_witel' => $this->witelKode,
                    'no_do' => $this->kodeDo,
                    'keterangan' => $this->ket,
                    'cek_status' => $this->cekStatus,
                    'sp' => $this->spPerangkat,
                    'perolehan' => $this->perolehan,
                ]);

            } catch (\Throwable $th) {
                return $this->addError('nikUser', 'Nik Sudah terdaftar');
            }
            
        } else {
            try {
                ModelsPerangkat::create([
                    'sn_lama' => $this->sn_lama,
                    'tipe_perangkat' => $this->tipePerangkat,
                    'sn_pengganti' => $this->sn_pengganti,
                    'sn_monitor' => $this->sn_monitor,
                    'id_user' => $this->userId,
                    'kode_image' => $this->imagePerangkat,
                    'kode_witel' => $this->witelKode,
                    'no_do' => $this->kodeDo,
                    'keterangan' => $this->ket,
                    'cek_status' => $this->cekStatus,
                    'sp' => $this->spPerangkat,
                    'perolehan' => $this->perolehan,
                ]);
            }catch (\Exception $ex) {
                return $this->addError('sn_lama', 'Sn Sudah ada');
            }
        }

        // Panggil fungsi Reset data
        $this->resetData();

        // Tutup Modal
        $this->isOpen = false;

        // Panggil SweetAlert berhasil
        $this->emit('success', 'Data Witel Berhasil Ditambahkan');
    }

    public function delete($id)
    {
      ModelsPerangkat::where(['id' => $id])->delete();
    }

    public function edit($id) 
    {
        // dd($id);
        $this->submitType = 'update';
        $this->dbPerangkat = ModelsPerangkat::where('id', $id)->first();
        if ($this->dbPerangkat['id_user'] != null) {
            $this->dbUser = User::where('id', $this->dbPerangkat['id_user'])->first();
            dd($this->dbUser);
            $this->namaUser = $this->dbUser['name'];
            $this->nikUser = $this->dbUser['nik'];
            $this->telpUser = $this->dbUser['no_telp'];
            $this->userId = $this->dbPerangkat['id_user'];
        }
        if ($this->dbPerangkat['kode_witel'] != null) {
            $this->dbWitel = Witel::where('kode_witel', $this->dbPerangkat['kode_witel'])->first();
            $this->witel = $this->dbWitel['nama_witel'];
            $this->witelKode = $this->dbWitel['kode_witel'];
        }

        $this->dbTipePerangkat = tipePerangkat::where('kode_perangkat', $this->dbPerangkat['tipe_perangkat'])->first();
        // Masukkan value ID
        $this->perangkatId = $id;

        $this->sn_lama = $this->dbPerangkat['sn_lama'];
        $this->tipePerangkat = $this->dbTipePerangkat['kode_perangkat'];
        $this->sn_pengganti = $this->dbPerangkat['sn_pengganti'];
        $this->sn_monitor = $this->dbPerangkat['sn_monitor'];
        $this->imagePerangkat = $this->dbPerangkat['kode_image'];
        $this->kodeDo = $this->dbPerangkat['no_do'];
        $this->ket = $this->dbPerangkat['keterangan'];
        $this->cekStatus = $this->dbPerangkat['cek_status'];
        $this->spPerangkat = $this->dbPerangkat['sp'];
        $this->perolehan = $this->dbPerangkat['perolehan'];
    }

    public function update() 
    {
        if ($this->addUser == true) {
            $nikValidate = ['nullable', 'numeric', Rule::unique('users', 'nik')->ignore($this->nikUser, 'nik')];
        } else {
            $nikValidate = '';
        }

        $this->validate([
            'sn_lama' => [Rule::unique('perangkat', 'sn_lama')->ignore($this->sn_lama, 'sn_lama'), 'nullable'],
            // 'sn_lama' => ['unique:App\Models\Perangkat,sn_lama,'.$this->sn_lama, 'nullable'],
            'tipePerangkat' => 'required',
            'sn_pengganti' => [Rule::unique('perangkat', 'sn_pengganti')->ignore($this->sn_pengganti, 'sn_pengganti')],
            'sn_monitor' => [Rule::unique('perangkat', 'sn_monitor')->ignore($this->sn_monitor, 'sn_monitor'), 'nullable'],
            'nikUser' => $nikValidate,
            'imagePerangkat' => 'required',
        ]);

        if ($this->addUser == true) {
            // Jika tambah user
            try {
                User::create([
                'name' => $this->namaUser,
                'nik' => $this->nikUser,
                'no_telp' => $this->telpUser,
                ]);

            // Ambil id user terakhir
            $getLastUser = User::get()->last();
            $this->userId = $getLastUser['id'];

                ModelsPerangkat::where('id', $this->perangkatId)->update([
                    'sn_lama' => $this->sn_lama,
                    'tipe_perangkat' => $this->tipePerangkat,
                    'sn_pengganti' => $this->sn_pengganti,
                    'sn_monitor' => $this->sn_monitor,
                    'id_user' => $this->userId,
                    'kode_image' => $this->imagePerangkat,
                    'kode_witel' => $this->witelKode,
                    'no_do' => $this->kodeDo,
                    'keterangan' => $this->ket,
                    'cek_status' => $this->cekStatus,
                    'sp' => $this->spPerangkat,
                    'perolehan' => $this->perolehan,
                ]);

            } catch (\Throwable $th) {
                return $this->addError('nikUser', 'Nik Sudah terdaftar');
            }
            
        } else {
            try {
                ModelsPerangkat::where('id', $this->perangkatId)->update([
                    'sn_lama' => $this->sn_lama,
                    'tipe_perangkat' => $this->tipePerangkat,
                    'sn_pengganti' => $this->sn_pengganti,
                    'sn_monitor' => $this->sn_monitor,
                    'id_user' => $this->userId,
                    'kode_image' => $this->imagePerangkat,
                    'kode_witel' => $this->witelKode,
                    'no_do' => $this->kodeDo,
                    'keterangan' => $this->ket,
                    'cek_status' => $this->cekStatus,
                    'sp' => $this->spPerangkat,
                    'perolehan' => $this->perolehan,
                ]);
            }catch (\Throwable $th) {
                return $this->addError('sn_lama', 'Sn Sudah ada');
            }
        }

        // Panggil fungsi Reset data
        $this->resetData();

        // Tutup Modal
        $this->isOpen = false;

        // Panggil SweetAlert berhasil
        $this->emit('success', 'Data Witel Berhasil Diubah');
    }

    public function chooseUser($id) 
    {
      $userData = User::where('id', $id)->first();
      $this->userId = $id;
      $this->namaUser = $userData['name'];
      $this->nikUser = $userData['nik'];
      $this->telpUser = $userData['no_telp'];
      $this->reset('userSearch');
    }

    public function addUser() 
    {
      $this->addUser = true;
      $this->reset('userSearch', 'namaUser', 'nikUser', 'telpUser'); 
    }

    public function chooseWitel($id) 
    {
        $witelData = Witel::where('id', $id)->first();
        $this->witelKode = $witelData['kode_witel'];
        $this->witel = $witelData['kode_witel'].' | '.$witelData['nama_witel'];
        $this->reset('witelSearch');
    }

    public function chooseDo($id) 
    {
        $DoData = DoModel::where('id', $id)->first();
        $this->doId = $id;
        $this->kodeDo = $DoData['no_do'];
        $this->reset('doSearch');
    }

    public function resetData() 
    {
        $this->addUser = false;
        // Reset Validasi
        $this->resetValidation();
        // Reset input field
        $this->reset('submitType', 'tipePerangkat', 'userSearch', 'witelSearch', 'doSearch', 'sn_lama', 'sn_pengganti', 'sn_monitor', 'imagePerangkat', 'witel', 'kodeDo', 'spPerangkat', 'cekStatus', 'perolehan', 'ket', 'namaUser', 'nikUser', 'telpUser');
    }

}
