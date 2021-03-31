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
            'perangkatData' => ModelsPerangkat::with(['Users', 'Witel'])->paginate(10),
            // 'perangkatData' => ModelsPerangkat::paginate(10),
            // 'perangkatData' => DB::table('perangkat')
            //                     ->join('users', 'id_user', '=', 'users.id')
            //                     ->join('witel', 'perangkat.kode_witel', '=', 'witel.kode_witel')
            //                     ->paginate(3),
        ];

        // dd($data['perangkatData']);

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
                throw $ex;
            }
        }

        // Panggil fungsi Reset data
        $this->resetData();

        // Tutup Modal
        $this->isOpen = false;

        // Panggil SweetAlert berhasil
        $this->emit('success', 'Data Witel Berhasil Ditambahkan');
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
        $this->reset('submitType', 'tipePerangkat', 'userSearch', 'witelSearch', 'doSearch', 'sn_lama', 'sn_pengganti', 'sn_monitor', 'imagePerangkat', 'witel', 'kodeDo', 'spPerangkat', 'cekStatus', 'perolehan', 'ket');
    }
}
