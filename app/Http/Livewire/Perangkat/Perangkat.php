<?php

namespace App\Http\Livewire\Perangkat;

use App\Models\ModelPengiriman;
use App\Models\ModelLogPerangkat as LogPerangkat;
use App\Models\ModelLogUser as LogUser;
use App\Models\ModelPerangkat as ModelsPerangkat;
use App\Models\ModelGelombang;
use App\Models\ModelTipePerangkat as TipePerangkat;
use App\Models\ModelUser as User;
use App\Models\ModelCabang as Cabang;
use App\Models\ModelTipeSistem;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Perangkat extends Component
{ 
    use WithPagination;
    public $tipePerangkat, $sn_lama, $sn_pengganti, 
    $sn_monitor, $sistemPerangkat, $cekStatus, $perolehan, 
    $gelombang, $ket, $oldSnLama, $oldSnPengganti, 
    $oldSnMonitor, $dataLama;
    public $dbPerangkat, $perangkatId, $dbCabang, $dbUser;
    public $namaUser, $nikUser, $telpUser, $userSearch, $userId;
    public $cabang, $cabangSearch, $cabangId;
    public $kodePengiriman, $pengirimanId, $pengirimanSearch;
    public $pengirimanData, $cabangData, $userData = '';

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
            $hasilUser = User::where('nama', 'like', $userSearchQuery)->limit(5)->get();
        }

        $hasilCabang = '';
        if (strlen($this->cabangSearch) > 0) {
            $cabangSearchQuery = '%'.$this->cabangSearch.'%';
            $hasilCabang = Cabang::where('nama_cabang', 'like', $cabangSearchQuery)->limit(5)->get();
        }

        $hasilPengiriman = '';
        if (strlen($this->pengirimanSearch) > 0) {
            $pengirimanSearchQuery = '%'.$this->pengirimanSearch.'%';
            $hasilPengiriman = ModelPengiriman::where('no_pengiriman', 'like', $pengirimanSearchQuery)->limit(5)->get();
        }

        $data = [
            'pengirimanResult' => $hasilPengiriman,
            'userResult' => $hasilUser,
            'cabangResult' => $hasilCabang,
            'gelombangDb' => ModelGelombang::all()->sortDesc(),
            'tipeSistem' => ModelTipeSistem::all(),
            'tipe' => tipePerangkat::all(),
            'perangkatData' => ModelsPerangkat::with('users', 'cabang', 'pengiriman', 'TipePerangkat', 'tipeSistem')
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
            'sn_lama' => 'unique:App\Models\ModelPerangkat,sn_lama|nullable',
            'tipePerangkat' => 'required',
            'sn_pengganti' => 'unique:App\Models\ModelPerangkat,sn_pengganti',
            'sn_monitor' => 'unique:App\Models\ModelPerangkat,sn_monitor|nullable',
            'nikUser' => $nikValidate,
            'sistemPerangkat' => 'required',
        ]);
        if ($this->sn_lama == null) {
            $this->sn_lama = null;
        }

        if ($this->pengirimanData == null) {
            $this->pengirimanData = ['id' => null, 'no_pengiriman' => null];
        }
        if ($this->cabangData == null) {
            $this->cabangData = ['id' => null, 'nama_cabang' => null];
        }
        if ($this->userData == null) {
            $this->userData = ['id' => null, 'nama' => null];
        }

        if ($this->sistemPerangkat) {
            $dataImage = ModelTipeSistem::where('id', $this->sistemPerangkat)->first();
        } else {
            $dataImage = ['id' => null, 'kode_sistem' => null];
        }

        if ($this->tipePerangkat) {
            $dataTipe = tipePerangkat::where('id', $this->tipePerangkat)->first();
        } else {
            $dataTipe = ['id' => null, 'kode_perangkat' => null];
        }
        

        if ($this->addUser == true) {
            // Jika tambah user
            try {
                User::create([
                'nama' => $this->namaUser,
                'nik' => $this->nikUser,
                'no_telp' => $this->telpUser,
                ]);

                // Ambil id user terakhir
                $getLastUser = User::latest()->first();
                $this->userId = $getLastUser['id'];

                ModelsPerangkat::create([
                    'sn_lama' => $this->sn_lama,
                    'id_tipe' => $this->tipePerangkat,
                    'sn_pengganti' => $this->sn_pengganti,
                    'sn_monitor' => $this->sn_monitor,
                    'id_user' => $this->userId,
                    'id_sistem' => $this->sistemPerangkat,
                    'id_cabang' => $this->cabangId,
                    'id_pengiriman' => $this->pengirimanId,
                    'keterangan' => $this->ket,
                    'cek_status' => $this->cekStatus,
                    'gelombang' => $this->gelombang,
                    'perolehan' => $this->perolehan,
                ]);

                // Ambil Id Perangkat terakhir
                $getLastPerangkat = ModelsPerangkat::latest()->first();
                LogPerangkat::create([
                    'id_perangkat' => $getLastPerangkat['id'],
                    'data_log' => [
                                    'aksi' => 'Tambah',
                                    'browser' => $_SERVER['HTTP_USER_AGENT'],
                                    'edited_by' => session('nama'),
                                    'data_lama' =>  [],
                                    'data_baru' =>  [
                                                        'sn_lama' => $this->sn_lama,
                                                        'sn_pengganti' => $this->sn_pengganti,
                                                        'sn_monitor' => $this->sn_monitor,
                                                        'id_tipe' => $dataTipe['id'],
                                                        'tipe' => $dataTipe['kode_perangkat'],
                                                        'id_user' => $this->userData['id'],
                                                        'user' => $this->userData['nama'],
                                                        'id_sistem' => $dataImage['id'],
                                                        'sistem' => $dataImage['kode_sistem'],
                                                        'id_cabang' => $this->cabangData['id'],
                                                        'cabang' => $this->cabangData['nama_cabang'],
                                                        'id_pengiriman' => $this->pengirimanData['id'],
                                                        'no_pengiriman' => $this->pengirimanData['no_pengiriman'],
                                                        'ket' => $this->ket,
                                                        'cek_status' => $this->cekStatus,
                                                        'perolehan' => $this->perolehan,
                                                        'gelombang' => $this->gelombang,
                                                    ],
                                ],
                ]);

                LogUser::create([
                    'id_user' => $this->userId,
                    'data_log' => [
                                    'aksi' => 'Tambah',
                                    'browser' => $_SERVER['HTTP_USER_AGENT'],
                                    'edited_by' => session('nama'),
                                    'data_lama' =>  [],
                                    'data_baru' =>  [
                                                        'nama' => $getLastUser['nama'],
                                                        'nik' => $getLastUser['nik'],
                                                        'no_telp' => $getLastUser['no_telp'],
                                                    ],
                                    ],
                    ]);

            } catch (\Exception $ex) {
                throw $ex;
                return $this->addError('nikUser', 'Nik Sudah terdaftar');
            }
            
        } else {
            try {
                ModelsPerangkat::create([
                    'sn_lama' => $this->sn_lama,
                    'id_tipe' => $this->tipePerangkat,
                    'sn_pengganti' => $this->sn_pengganti,
                    'sn_monitor' => $this->sn_monitor,
                    'id_user' => $this->userId,
                    'id_sistem' => $this->sistemPerangkat,
                    'id_cabang' => $this->cabangId,
                    'id_pengiriman' => $this->pengirimanId,
                    'keterangan' => $this->ket,
                    'cek_status' => $this->cekStatus,
                    'gelombang' => $this->gelombang,
                    'perolehan' => $this->perolehan,
                ]);

                $getLastPerangkat = ModelsPerangkat::latest()->first();
                LogPerangkat::create([
                    'id_perangkat' => $getLastPerangkat['id'],
                    'data_log' => [
                                    'aksi' => 'Tambah',
                                    'browser' => $_SERVER['HTTP_USER_AGENT'],
                                    'edited_by' => session('nama'),
                                    'data_lama' =>  [],
                                    'data_baru' =>  [
                                                        'sn_lama' => $this->sn_lama,
                                                        'sn_pengganti' => $this->sn_pengganti,
                                                        'sn_monitor' => $this->sn_monitor,
                                                        'id_tipe' => $dataTipe['id'],
                                                        'tipe' => $dataTipe['kode_perangkat'],
                                                        'id_user' => $this->userData['id'],
                                                        'user' => $this->userData['nama'],
                                                        'id_sistem' => $dataImage['id'],
                                                        'sistem' => $dataImage['kode_sistem'],
                                                        'id_cabang' => $this->cabangData['id'],
                                                        'cabang' => $this->cabangData['nama_cabang'],
                                                        'id_pengiriman' => $this->pengirimanData['id'],
                                                        'no_pengiriman' => $this->pengirimanData['no_pengiriman'],
                                                        'ket' => $this->ket,
                                                        'cek_status' => $this->cekStatus,
                                                        'perolehan' => $this->perolehan,
                                                        'gelombang' => $this->gelombang,
                                                    ],
                                ],
                ]);
            }catch (\Exception $ex) {
                throw $ex;
                return $this->addError('sn_lama', 'Sn Sudah ada');
            }
        }

        // Panggil fungsi Reset data
        $this->resetData();

        // Tutup Modal
        $this->isOpen = false;
        $this->addUser = false;

        // Panggil SweetAlert berhasil
        $this->emit('success', 'Data Cabang Berhasil Ditambahkan');
    }

    public function delete($id)
    {
        $getDataPerangkat = ModelsPerangkat::where(['id' => $id])->first();
        $getDataPerangkat->delete();
        $getDataTipe = tipePerangkat::where('id', $getDataPerangkat['id_tipe'])->withTrashed()->first();
        $getDataSistem = ModelTipeSistem::where('id', $getDataPerangkat['id_sistem'])->withTrashed()->first();

        // get User
        if ($getDataPerangkat['id_user']) {
            $getDataUser = User::where('id', $getDataPerangkat['id_user'])->withTrashed()->first();
        } else {
            $getDataUser = ['id' => null, 'nama' => null];
        }

        // Get Cabang
        if ($getDataPerangkat['id_cabang']) {
            $getDataCabang = Cabang::where('id', $getDataPerangkat['id_cabang'])->withTrashed()->first();
        } else {
            $getDataCabang = ['id' => null, 'nama_cabang' => null];
        }

        // Get DO
        if ($getDataPerangkat['id_pengiriman']) {
            $getDataPengiriman = ModelPengiriman::where('id', $getDataPerangkat['id_pengiriman'])->withTrashed()->first();
        } else {
            $getDataPengiriman = ['id' => null, 'no_pengiriman' => null];
        }

        LogPerangkat::create([
            'id_perangkat' => $id,
            'data_log' => [
                            'aksi' => 'Hapus',
                            'browser' => $_SERVER['HTTP_USER_AGENT'],
                            'edited_by' => session('nama'),
                            'data_lama' =>  [
                                                'sn_lama' => $getDataPerangkat['sn_lama'],
                                                'sn_pengganti' => $getDataPerangkat["sn_pengganti"],
                                                'sn_monitor' => $getDataPerangkat['sn_monitor'],
                                                'id_tipe' => $getDataTipe['id'],
                                                'tipe' => $getDataTipe['kode_perangkat'],
                                                'id_user' => $getDataUser['id'],
                                                'user' => $getDataUser['nama'],
                                                'id_sistem' => $getDataSistem['id'],
                                                'sistem' => $getDataSistem['kode_sistem'],
                                                'id_cabang' => $getDataCabang['id'],
                                                'cabang' => $getDataCabang['nama_cabang'],
                                                'id_pengiriman' => $getDataPengiriman['id'],
                                                'no_pengiriman' => $getDataPengiriman['no_pengiriman'],
                                                'ket' => $getDataPerangkat['keterangan'],
                                                'cek_status' => $getDataPerangkat['cek_status'],
                                                'perolehan' => $getDataPerangkat['perolehan'],
                                                'gelombang' => $getDataPerangkat['gelombang'],
                                            ],
                            'data_baru' =>  [],
                        ],
        ]);
    }

    public function edit($id) 
    {
        $this->submitType = 'update';
        $this->dbPerangkat = ModelsPerangkat::where('id', $id)->first();
        $this->perangkatId = $id;

        if ($this->dbPerangkat['id_user'] != null) {
            $this->dbUser = User::where('id', $this->dbPerangkat['id_user'])->withTrashed()->first();
            $this->namaUser = $this->dbUser['nama'];
            $this->nikUser = $this->dbUser['nik'];
            $this->telpUser = $this->dbUser['no_telp'];
            $this->userId = $this->dbPerangkat['id_user'];
        }

        if ($this->dbPerangkat['id_cabang'] != null) {
            
            $this->dbCabang = Cabang::where('id', $this->dbPerangkat['id_cabang'])->withTrashed()->first();
            $this->cabang = $this->dbCabang['nama_cabang'];
            $this->cabangId = $this->dbCabang['id_cabang'];
        }

        if ($this->dbPerangkat['id_pengiriman'] != null) {

            $dbDo = ModelPengiriman::where('id', $this->dbPerangkat['id_pengiriman'])->withTrashed()->first();
            $this->pengirimanId = $this->dbPerangkat['id_pengiriman'];
            $this->kodePengiriman = $dbDo['no_pengiriman'];
        }

        // $this->dbTipePerangkat = tipePerangkat::where('id', $this->dbPerangkat['id_tipe'])->withTrashed()->first();
        $this->oldSnLama = $this->dbPerangkat['sn_lama'];
        $this->oldSnPengganti = $this->dbPerangkat['sn_pengganti'];
        $this->oldSnMonitor = $this->dbPerangkat['sn_monitor'];

        $this->sn_lama = $this->dbPerangkat['sn_lama'];
        $this->tipePerangkat = $this->dbPerangkat['id_tipe'];
        $this->sn_pengganti = $this->dbPerangkat['sn_pengganti'];
        $this->sn_monitor = $this->dbPerangkat['sn_monitor'];
        $this->sistemPerangkat = $this->dbPerangkat['id_sistem'];
        
        $this->ket = $this->dbPerangkat['keterangan'];
        $this->cekStatus = $this->dbPerangkat['cek_status'];
        $this->gelombang = $this->dbPerangkat['gelombang'];
        $this->perolehan = $this->dbPerangkat['perolehan'];

        // untuk Log
        $getDataTipe = tipePerangkat::where('id', $this->dbPerangkat['id_tipe'])->withTrashed()->first();
        $getDataImage = ModelTipeSistem::where('id', $this->dbPerangkat['id_sistem'])->withTrashed()->first();

        // get User
        if ($this->dbPerangkat['id_user']) {
            $getDataUser = User::where('id', $this->dbPerangkat['id_user'])->withTrashed()->first();
        } else {
            $getDataUser = ['id' => null, 'nama' => null];
        }

        // Get Cabang
        if ($this->dbPerangkat['id_cabang']) {
            $getDataCabang = Cabang::where('id', $this->dbPerangkat['id_cabang'])->withTrashed()->first();
        } else {
            $getDataCabang = ['id' => null, 'nama_cabang' => null];
        }

        // Get DO
        if ($this->dbPerangkat['id_pengiriman']) {
            $getDataPengiriman = ModelPengiriman::where('id', $this->dbPerangkat['id_pengiriman'])->withTrashed()->first();
        } else {
            $getDataPengiriman = ['id' => null, 'no_pengiriman' => null];
        }

        $this->dataLama = [
            'sn_lama' => $this->dbPerangkat['sn_lama'],
            'sn_pengganti' => $this->dbPerangkat['sn_pengganti'],
            'sn_monitor' => $this->dbPerangkat['sn_monitor'],
            'id_tipe' => $this->dbPerangkat['id_tipe'],
            'tipe' => $getDataTipe['kode_perangkat'],
            'id_user' => $this->dbPerangkat['id_user'],
            'user' => $getDataUser['nama'],
            'id_sistem' => $this->dbPerangkat['id_sistem'],
            'sistem' => $getDataImage['kode_sistem'],
            'id_cabang' => $this->dbPerangkat['id_cabang'],
            'cabang' => $getDataCabang['nama_cabang'],
            'id_pengiriman' => $this->dbPerangkat['id_pengiriman'],
            'no_pengiriman' => $getDataPengiriman['no_pengiriman'],
            'ket' => $this->dbPerangkat['keterangan'],
            'cek_status' => $this->dbPerangkat['cek_status'],
            'perolehan' => $this->dbPerangkat['perolehan'],
            'gelombang' => $this->dbPerangkat['gelombang'],
        ];
    }

    public function update() 
    {
        if ($this->addUser == true) {
            $nikValidate = ['nullable', 'numeric', Rule::unique('users', 'nik')->ignore($this->nikUser, 'nik')];
        } else {
            $nikValidate = '';
        }

        $this->validate([
            'sn_lama' => [Rule::unique('perangkat', 'sn_lama')->ignore($this->oldSnLama, 'sn_lama'), 'nullable'],
            'tipePerangkat' => 'required',
            'sn_pengganti' => [Rule::unique('perangkat', 'sn_pengganti')->ignore($this->oldSnPengganti, 'sn_pengganti')],
            'sn_monitor' => [Rule::unique('perangkat', 'sn_monitor')->ignore($this->oldSnMonitor, 'sn_monitor'), 'nullable'],
            'nikUser' => $nikValidate,
            'sistemPerangkat' => 'required',
        ]);

        $getDataTipe = tipePerangkat::where('id', $this->tipePerangkat)->withTrashed()->first();
        $getDataImage = ModelTipeSistem::where('id', $this->sistemPerangkat)->withTrashed()->first();

        // Get Cabang
        if ($this->cabangId) {
            $getDataCabang = Cabang::where('id', $this->cabangId)->withTrashed()->first();
        } else {
            $getDataCabang = ['id' => null, 'nama_cabang' => null];
        }

        // get User
        if ($this->userId) {
            $getDataUser = User::where('id', $this->userId)->withTrashed()->first();
        } else {
            $getDataUser = ['id' => null, 'nama' => null];
        }

        // Get DO
        if ($this->pengirimanId) {
            $getDataPengiriman = ModelPengiriman::where('id', $this->pengirimanId)->withTrashed()->first();
        } else {
            $getDataPengiriman = ['id' => null, 'no_pengiriman' => null];
        }

        if ($this->addUser == true) {
            // Jika tambah user
            try {
                User::create([
                'nama' => $this->namaUser,
                'nik' => $this->nikUser,
                'no_telp' => $this->telpUser,
                ]);

                // Ambil id user terakhir
                $getLastUser = User::get()->last();
                $this->userId = $getLastUser['id'];

                // get User
                if ($this->userId) {
                    $getDataUser = User::where('id', $this->userId)->withTrashed()->first();
                } else {
                    $getDataUser = ['id' => null, 'nama' => null];
                }

                ModelsPerangkat::where('id', $this->perangkatId)->update([
                    'sn_lama' => $this->sn_lama,
                    'id_tipe' => $this->tipePerangkat,
                    'sn_pengganti' => $this->sn_pengganti,
                    'sn_monitor' => $this->sn_monitor,
                    'id_user' => $this->userId,
                    'id_sistem' => $this->sistemPerangkat,
                    'id_cabang' => $this->cabangId,
                    'id_pengiriman' => $this->pengirimanId,
                    'keterangan' => $this->ket,
                    'cek_status' => $this->cekStatus,
                    'gelombang' => $this->gelombang,
                    'perolehan' => $this->perolehan,
                ]);

                LogPerangkat::create([
                    'id_perangkat' => $this->perangkatId,
                    'data_log' => [
                                    'aksi' => 'Edit',
                                    'browser' => $_SERVER['HTTP_USER_AGENT'],
                                    'edited_by' => session('nama'),
                                    'data_lama' =>  [
                                                        'sn_lama' => $this->dataLama['sn_lama'],
                                                        'sn_pengganti' => $this->dataLama['sn_pengganti'],
                                                        'sn_monitor' => $this->dataLama['sn_monitor'],
                                                        'id_tipe' => $this->dataLama['id_tipe'],
                                                        'tipe' => $this->dataLama['tipe'],
                                                        'id_user' => $this->dataLama['id_user'],
                                                        'user' => $this->dataLama['user'],
                                                        'id_sistem' => $this->dataLama['id_sistem'],
                                                        'sistem' => $this->dataLama['sistem'],
                                                        'id_cabang' => $this->dataLama['id_cabang'],
                                                        'cabang' => $this->dataLama['cabang'],
                                                        'id_pengiriman' => $this->dataLama['id_pengiriman'],
                                                        'no_pengiriman' => $this->dataLama['no_pengiriman'],
                                                        'ket' => $this->dataLama['ket'],
                                                        'cek_status' => $this->dataLama['cek_status'],
                                                        'perolehan' => $this->dataLama['perolehan'],
                                                        'gelombang' => $this->dataLama['gelombang'],
                                                    ],
                                    'data_baru' =>  [
                                                        'sn_lama' => $this->sn_lama,
                                                        'sn_pengganti' => $this->sn_pengganti,
                                                        'sn_monitor' => $this->sn_monitor,
                                                        'id_tipe' => $getDataTipe['id'],
                                                        'tipe' => $getDataTipe['kode_perangkat'],
                                                        'id_user' => $getDataUser['id'],
                                                        'user' => $getDataUser['nama'],
                                                        'id_sistem' => $getDataImage['id'],
                                                        'sistem' => $getDataImage['kode_sistem'],
                                                        'id_cabang' => $getDataCabang['id'],
                                                        'cabang' => $getDataCabang['nama_cabang'],
                                                        'id_pengiriman' => $getDataPengiriman['id'],
                                                        'no_pengiriman' => $getDataPengiriman['no_pengiriman'],
                                                        'ket' => $this->ket,
                                                        'cek_status' => $this->cekStatus,
                                                        'perolehan' => $this->perolehan,
                                                        'gelombang' => $this->gelombang,
                                                    ],
                                ],
                ]);

                LogUser::create([
                    'id_user' => $this->userId,
                    'data_log' => [
                                    'aksi' => 'Tambah',
                                    'browser' => $_SERVER['HTTP_USER_AGENT'],
                                    'edited_by' => session('nama'),
                                    'data_lama' =>  [],
                                    'data_baru' =>  [
                                                        'nama' => $getLastUser['nama'],
                                                        'nik' => $getLastUser['nik'],
                                                        'no_telp' => $getLastUser['no_telp'],
                                                    ],
                                    ],
                    ]);

            } catch (\Throwable $th) {
                return $this->addError('nikUser', 'Nik Sudah terdaftar');
            }
            
        } else {
            try {
                ModelsPerangkat::where('id', $this->perangkatId)->update([
                    'sn_lama' => $this->sn_lama,
                    'id_tipe' => $this->tipePerangkat,
                    'sn_pengganti' => $this->sn_pengganti,
                    'sn_monitor' => $this->sn_monitor,
                    'id_user' => $this->userId,
                    'id_sistem' => $this->sistemPerangkat,
                    'id_cabang' => $this->cabangId,
                    'id_pengiriman' => $this->pengirimanId,
                    'keterangan' => $this->ket,
                    'cek_status' => $this->cekStatus,
                    'gelombang' => $this->gelombang,
                    'perolehan' => $this->perolehan,
                ]);

                LogPerangkat::create([
                    'id_perangkat' => $this->perangkatId,
                    'data_log' => [
                                    'aksi' => 'Edit',
                                    'browser' => $_SERVER['HTTP_USER_AGENT'],
                                    'edited_by' => session('nama'),
                                    'data_lama' =>  [
                                                        'sn_lama' => $this->dataLama['sn_lama'],
                                                        'sn_pengganti' => $this->dataLama['sn_pengganti'],
                                                        'sn_monitor' => $this->dataLama['sn_monitor'],
                                                        'id_tipe' => $this->dataLama['id_tipe'],
                                                        'tipe' => $this->dataLama['tipe'],
                                                        'id_user' => $this->dataLama['id_user'],
                                                        'user' => $this->dataLama['user'],
                                                        'id_sistem' => $this->dataLama['id_sistem'],
                                                        'sistem' => $this->dataLama['sistem'],
                                                        'id_cabang' => $this->dataLama['id_cabang'],
                                                        'cabang' => $this->dataLama['cabang'],
                                                        'id_pengiriman' => $this->dataLama['id_pengiriman'],
                                                        'no_pengiriman' => $this->dataLama['no_pengiriman'],
                                                        'ket' => $this->dataLama['ket'],
                                                        'cek_status' => $this->dataLama['cek_status'],
                                                        'perolehan' => $this->dataLama['perolehan'],
                                                        'gelombang' => $this->dataLama['gelombang'],
                                                    ],
                                    'data_baru' =>  [
                                                        'sn_lama' => $this->sn_lama,
                                                        'sn_pengganti' => $this->sn_pengganti,
                                                        'sn_monitor' => $this->sn_monitor,
                                                        'id_tipe' => $getDataTipe['id'],
                                                        'tipe' => $getDataTipe['kode_perangkat'],
                                                        'id_user' => $getDataUser['id'],
                                                        'user' => $getDataUser['nama'],
                                                        'id_sistem' => $getDataImage['id'],
                                                        'sistem' => $getDataImage['kode_sistem'],
                                                        'id_cabang' => $getDataCabang['id'],
                                                        'cabang' => $getDataCabang['nama_cabang'],
                                                        'id_pengiriman' => $getDataPengiriman['id'],
                                                        'no_pengiriman' => $getDataPengiriman['no_pengiriman'],
                                                        'ket' => $this->ket,
                                                        'cek_status' => $this->cekStatus,
                                                        'perolehan' => $this->perolehan,
                                                        'gelombang' => $this->gelombang,
                                                    ],
                                ],
                ]);
            }catch (\Exception $ex) {
                throw $ex;
                // return $this->addError('sn_lama', 'Sn Sudah ada');
            }
        }

        // Panggil fungsi Reset data
        $this->resetData();

        // Tutup Modal
        $this->isOpen = false;

        // Panggil SweetAlert berhasil
        $this->emit('success', 'Data Cabang Berhasil Diubah');
    }

    public function addUser() 
    {
      $this->addUser = true;
      $this->reset('userSearch', 'namaUser', 'nikUser', 'telpUser'); 
    }

    public function chooseUser($id) 
    {
      $this->userData = User::where('id', $id)->first();
      $this->userId = $id;
      $this->namaUser = $this->userData['nama'];
      $this->nikUser = $this->userData['nik'];
      $this->telpUser = $this->userData['no_telp'];
      $this->reset('userSearch');
    }

    public function chooseCabang($id) 
    {
        $this->cabangData = Cabang::where('id', $id)->first();
        $this->cabangId = $id;
        $this->cabang = $this->cabangData['kode_cabang'].' | '.$this->cabangData['nama_cabang'];
        $this->reset('cabangSearch');
    }

    public function choosePengiriman($id) 
    {
        $this->pengirimanData = ModelPengiriman::where('id', $id)->first();
        $this->pengirimanId = $id;
        $this->kodePengiriman = $this->pengirimanData['no_pengiriman'];
        $this->reset('pengirimanSearch');
    }

    public function resetData() 
    {
        $this->addUser = false;
        // Reset Validasi
        $this->resetValidation();
        // Reset input field
        // $this->reset('submitType', 'tipePerangkat', 'userSearch', 'cabangSearch', 'pengirimanSearch', 'sn_lama', 'sn_pengganti', 'sn_monitor', 'sistemPerangkat', 'cabang', 'cabangId', 'kodePengiriman', 'gelombang', 'cekStatus', 'perolehan', 'ket', 'namaUser', 'nikUser', 'telpUser', 'pengirimanId');
        $this->reset();
    }

}
