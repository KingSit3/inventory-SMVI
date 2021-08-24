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
    $gelombang, $ket = null;
    public $dbPerangkat, $perangkatId;
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
            $namaValidate = ['required', 'max:100'];
            $noTelpvalidate = ['nullable', 'max:50'];
        } else {
            $nikValidate = '';
            $noTelpvalidate = '';
            $namaValidate= '';
        }

        $this->validate([
            'sn_lama' => 'unique:App\Models\ModelPerangkat,sn_lama|nullable',
            'tipePerangkat' => 'required',
            'sn_pengganti' => 'unique:App\Models\ModelPerangkat,sn_pengganti',
            'sn_monitor' => 'unique:App\Models\ModelPerangkat,sn_monitor|nullable',
            'nikUser' => $nikValidate,
            'namaUser' => $namaValidate,
            'telpUser' => $noTelpvalidate,
            'sistemPerangkat' => 'required',
        ]);

        if (!$this->pengirimanData) {
            $this->pengirimanData = ['id' => null, 'no_pengiriman' => null];
        }
        
        if (!$this->cabangData) {
            $this->cabangData = ['id' => null, 'nama_cabang' => null];
        }

        if (!$this->userData) {
            $this->userData = ['id' => null, 'nama' => null];
        }

        if ($this->sistemPerangkat) {
            $dataSistem = ModelTipeSistem::where('id', $this->sistemPerangkat)->first();
        } else {
            $dataSistem = ['id' => null, 'kode_sistem' => null];
        }

        if ($this->tipePerangkat) {
            $dataTipe = tipePerangkat::where('id', $this->tipePerangkat)->first();
        } else {
            $dataTipe = ['id' => null, 'kode_perangkat' => null];
        }
        
        if ($this->addUser == true) {
            // Jika tambah user
            try {
                $saveUser = User::create([
                'nama' => $this->namaUser,
                'nik' => (trim($this->nikUser) == '') ? null : $this->nikUser,
                'no_telp' => $this->telpUser,
                ]);

                $savePerangkat = ModelsPerangkat::create([
                    'sn_lama' => (trim($this->sn_lama) == '') ? null : strtoupper($this->sn_lama),
                    'sn_pengganti' => strtoupper($this->sn_pengganti),
                    'sn_monitor' => (trim($this->sn_monitor) == '') ? null : strtoupper($this->sn_monitor),
                    'id_user' => $saveUser->id,
                    'id_tipe' => $this->tipePerangkat,
                    'id_sistem' => $this->sistemPerangkat,
                    'id_cabang' => $this->cabangId,
                    'id_pengiriman' => $this->pengirimanId,
                    'keterangan' => $this->ket,
                    'cek_status' => $this->cekStatus,
                    'gelombang' => $this->gelombang,
                    'perolehan' => $this->perolehan,
                ]);

                LogPerangkat::create([ 
                    'id_perangkat' => $savePerangkat['id'],
                    'data_log' => [
                                    'aksi' => 'Tambah',
                                    'browser' => $_SERVER['HTTP_USER_AGENT'],
                                    'edited_by' => session('nama'),
                                    'data_lama' =>  [],
                                    'data_baru' =>  [
                                                        'sn_lama' => strtoupper($this->sn_lama),
                                                        'sn_pengganti' => strtoupper($this->sn_pengganti),
                                                        'sn_monitor' => strtoupper($this->sn_monitor),
                                                        'id_tipe' => $dataTipe['id'],
                                                        'tipe' => $dataTipe['kode_perangkat'],
                                                        'id_user' => $this->userData['id'],
                                                        'user' => $this->userData['nama'],
                                                        'id_sistem' => $dataSistem['id'],
                                                        'sistem' => $dataSistem['kode_sistem'],
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
                    'id_user' => $saveUser->id,
                    'data_log' => [
                                    'aksi' => 'Tambah',
                                    'browser' => $_SERVER['HTTP_USER_AGENT'],
                                    'edited_by' => session('nama'),
                                    'data_lama' =>  [],
                                    'data_baru' =>  [
                                                        'nama' => $saveUser->nama,
                                                        'nik' => $saveUser->nik,
                                                        'no_telp' => $saveUser->no_telp,
                                                    ],
                                    ],
                    ]);

            } catch (\Exception $ex) {
                // throw $ex;
                return $this->addError('nikUser', 'Nik Sudah terdaftar');
            }
            
        } else {
            try {
                $savePerangkat = ModelsPerangkat::create([
                    'sn_lama' => (trim($this->sn_lama) == '') ? null : strtoupper($this->sn_lama),
                    'sn_pengganti' => strtoupper($this->sn_pengganti),
                    'sn_monitor' => (trim($this->sn_monitor) == '') ? null : strtoupper($this->sn_monitor),
                    'id_tipe' => $this->tipePerangkat,
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
                    'id_perangkat' => $savePerangkat->id,
                    'data_log' => [
                                    'aksi' => 'Tambah',
                                    'browser' => $_SERVER['HTTP_USER_AGENT'],
                                    'edited_by' => session('nama'),
                                    'data_lama' =>  [],
                                    'data_baru' =>  [
                                                        'sn_lama' => strtoupper($this->sn_lama),
                                                        'sn_pengganti' => strtoupper($this->sn_pengganti),
                                                        'sn_monitor' => strtoupper($this->sn_monitor),
                                                        'id_tipe' => $dataTipe['id'],
                                                        'tipe' => $dataTipe['kode_perangkat'],
                                                        'id_user' => $this->userData['id'],
                                                        'user' => $this->userData['nama'],
                                                        'id_sistem' => $dataSistem['id'],
                                                        'sistem' => $dataSistem['kode_sistem'],
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
                // throw $ex;
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
        $getDataPerangkat = ModelsPerangkat::with('tipeSistem', 'tipePerangkat', 'users', 'cabang', 'pengiriman')
                                            ->where(['id' => $id])
                                            ->first();

        // get User
        if (!$getDataPerangkat['id_user']) {
            $getDataPerangkat['users'] = ['id' => null, 'nama' => null];
        } 

        // Get Cabang
        if (!$getDataPerangkat['id_cabang']) {
            $getDataPerangkat['cabang'] = ['id' => null, 'nama_cabang' => null];
        }

        // Get Pengiriman
        if (!$getDataPerangkat['id_pengiriman']) {
            $getDataPerangkat['pengiriman'] = ['id' => null, 'no_pengiriman' => null];
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
                                                'id_tipe' => $getDataPerangkat['TipePerangkat']['id'],
                                                'tipe' => $getDataPerangkat['TipePerangkat']['kode_perangkat'],
                                                'id_user' => $getDataPerangkat['users']['id'],
                                                'user' => $getDataPerangkat['users']['nama'],
                                                'id_sistem' => $getDataPerangkat['tipeSistem']['id'],
                                                'sistem' => $getDataPerangkat['tipeSistem']['kode_sistem'],
                                                'id_cabang' => $getDataPerangkat['cabang']['id'],
                                                'cabang' => $getDataPerangkat['cabang']['nama_cabang'],
                                                'id_pengiriman' => $getDataPerangkat['pengiriman']['id'],
                                                'no_pengiriman' => $getDataPerangkat['pengiriman']['no_pengiriman'],
                                                'ket' => $getDataPerangkat['keterangan'],
                                                'cek_status' => $getDataPerangkat['cek_status'],
                                                'perolehan' => $getDataPerangkat['perolehan'],
                                                'gelombang' => $getDataPerangkat['gelombang'],
                                            ],
                            'data_baru' =>  [],
                        ],
        ]);

        $getDataPerangkat->delete();
    }

    public function edit($id) 
    {
        $this->submitType = 'update';
        $this->dbPerangkat = ModelsPerangkat::with('users', 'cabang', 'pengiriman', 'tipeSistem', 'TipePerangkat')->where('id', $id)->first();
        $this->perangkatId = $id;

        if ($this->dbPerangkat['id_user']) {
            $this->namaUser = $this->dbPerangkat['users']['nama'];
            $this->nikUser = $this->dbPerangkat['users']['nik'];
            $this->telpUser = $this->dbPerangkat['users']['no_telp'];
            $this->userId = $this->dbPerangkat['id_user'];
        }

        if ($this->dbPerangkat['id_cabang']) {
            $this->cabang = $this->dbPerangkat['cabang']['nama_cabang'];
            $this->cabangId = $this->dbPerangkat['id_cabang'];
        }

        if ($this->dbPerangkat['id_pengiriman']) {
            $this->kodePengiriman = $this->dbPerangkat['pengiriman']['no_pengiriman'];
            $this->pengirimanId = $this->dbPerangkat['id_pengiriman'];
        }

        // Populate forms
        $this->sn_lama = $this->dbPerangkat['sn_lama'];
        $this->tipePerangkat = $this->dbPerangkat['id_tipe'];
        $this->sn_pengganti = $this->dbPerangkat['sn_pengganti'];
        $this->sn_monitor = $this->dbPerangkat['sn_monitor'];
        $this->sistemPerangkat = $this->dbPerangkat['id_sistem'];
        $this->ket = $this->dbPerangkat['keterangan'];
        $this->cekStatus = $this->dbPerangkat['cek_status'];
        $this->gelombang = $this->dbPerangkat['gelombang'];
        $this->perolehan = $this->dbPerangkat['perolehan'];
    }

    public function update() 
    {
        if ($this->addUser == true) {
            $nikValidate = ['nullable', 'numeric', Rule::unique('users', 'nik')->ignore($this->nikUser, 'nik')];
            $namaValidate = ['required', 'max:100'];
            $noTelpvalidate = ['nullable', 'max:50'];
        } else {
            $nikValidate = '';
            $noTelpvalidate = '';
            $namaValidate= '';
        }

        $this->validate([
            'sn_lama' => [Rule::unique('perangkat', 'sn_lama')->ignore($this->dbPerangkat['sn_lama'], 'sn_lama'), 'nullable'],
            'tipePerangkat' => 'required',
            'sn_pengganti' => [Rule::unique('perangkat', 'sn_pengganti')->ignore($this->dbPerangkat['sn_pengganti'], 'sn_pengganti')],
            'sn_monitor' => [Rule::unique('perangkat', 'sn_monitor')->ignore($this->dbPerangkat['sn_monitor'], 'sn_monitor'), 'nullable'],
            'nikUser' => $nikValidate,
            'namaUser' => $namaValidate,
            'telpUser' => $noTelpvalidate,
            'sistemPerangkat' => 'required',
        ]);

        $newTipePerangkat = tipePerangkat::where('id', $this->tipePerangkat)->withTrashed()->first();
        $newTipeSistem = ModelTipeSistem::where('id', $this->sistemPerangkat)->withTrashed()->first();

        // get User
        if (!$this->userId) {
            $getDataUser = ['id' => null, 'nama' => null];
        } else {
            $getDataUser = User::where('id', $this->userId)->withTrashed()->first();
        }

        // Get Cabang
        if (!$this->cabangId) {
            $getDataCabang = ['id' => null, 'nama_cabang' => null];
        } else {
            $getDataCabang = Cabang::where('id', $this->cabangId)->withTrashed()->first();
        }

        // Get Pengiriman
        if (!$this->pengirimanId) {
            $getDataPengiriman = ['id' => null, 'no_pengiriman' => null];
        } else {
            $getDataPengiriman = ModelPengiriman::where('id', $this->pengirimanId)->withTrashed()->first();
        }

        if ($this->addUser == true) {
            // Jika tambah user
            try {
                $saveUser = User::create([
                'nama' => $this->namaUser,
                'nik' => (trim($this->nikUser) == '') ? null : $this->nikUser,
                'no_telp' => $this->telpUser,
                ]);

                ModelsPerangkat::where('id', $this->perangkatId)->update([
                    'sn_lama' => (trim($this->sn_lama) == '') ? null : strtoupper($this->sn_lama),
                    'sn_pengganti' => strtoupper($this->sn_pengganti),
                    'sn_monitor' => (trim($this->sn_monitor) == '') ? null : strtoupper($this->sn_monitor),
                    'id_tipe' => $this->tipePerangkat,
                    'id_user' => $saveUser->id,
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
                                                        'sn_lama' => $this->dbPerangkat['sn_lama'],
                                                        'sn_pengganti' => $this->dbPerangkat['sn_pengganti'],
                                                        'sn_monitor' => $this->dbPerangkat['sn_monitor'],
                                                        'id_tipe' => $this->dbPerangkat['TipePerangkat']['id'],
                                                        'tipe' => $this->dbPerangkat['TipePerangkat']['nama_perangkat'],
                                                        'id_user' => $this->dbPerangkat['users']['id'],
                                                        'user' => $this->dbPerangkat['users']['nama'],
                                                        'id_sistem' => $this->dbPerangkat['tipeSistem']['id'],
                                                        'sistem' => $this->dbPerangkat['tipeSistem']['kode_sistem'],
                                                        'id_cabang' => $this->dbPerangkat['cabang']['id'],
                                                        'cabang' => $this->dbPerangkat['cabang']['nama_cabang'],
                                                        'id_pengiriman' => $this->dbPerangkat['pengiriman']['id'],
                                                        'no_pengiriman' => $this->dbPerangkat['pengiriman']['no_pengiriman'],
                                                        'ket' => $this->dbPerangkat['keterangan'],
                                                        'cek_status' => $this->dbPerangkat['cek_status'],
                                                        'perolehan' => $this->dbPerangkat['perolehan'],
                                                        'gelombang' => $this->dbPerangkat['gelombang'],
                                                    ],
                                    'data_baru' =>  [
                                                        'sn_lama' => strtoupper($this->sn_lama),
                                                        'sn_pengganti' => strtoupper($this->sn_pengganti),
                                                        'sn_monitor' => strtoupper($this->sn_monitor),
                                                        'id_tipe' => $newTipePerangkat['id'],
                                                        'tipe' => $newTipePerangkat['kode_perangkat'],
                                                        'id_user' => $saveUser->id,
                                                        'user' => $saveUser->nama,
                                                        'id_sistem' => $newTipeSistem['id'],
                                                        'sistem' => $newTipeSistem['kode_sistem'],
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
                    'id_user' => $saveUser->id,
                    'data_log' => [
                                    'aksi' => 'Tambah',
                                    'browser' => $_SERVER['HTTP_USER_AGENT'],
                                    'edited_by' => session('nama'),
                                    'data_lama' =>  [],
                                    'data_baru' =>  [
                                                        'nama' => $saveUser->nama,
                                                        'nik' => $saveUser->nik,
                                                        'no_telp' => $saveUser->no_telp,
                                                    ],
                                    ],
                    ]);

            } catch (\Throwable $th) {
                throw $th;
                return $this->addError('nikUser', 'Nik Sudah terdaftar');
            }
            
        } else {
            try {
                ModelsPerangkat::where('id', $this->perangkatId)->update([
                    'sn_lama' => (trim($this->sn_lama) == '') ? null : strtoupper($this->sn_lama),
                    'sn_pengganti' => strtoupper($this->sn_pengganti),
                    'sn_monitor' => (trim($this->sn_monitor) == '') ? null : strtoupper($this->sn_monitor),
                    'id_tipe' => $this->tipePerangkat,
                    'id_user' => $this->userId,
                    'id_sistem' => $this->sistemPerangkat,
                    'id_cabang' => $this->cabangId,
                    'id_pengiriman' => $this->pengirimanId,
                    'keterangan' => $this->ket,
                    'cek_status' => $this->cekStatus,
                    'gelombang' => $this->gelombang,
                    'perolehan' => $this->perolehan,
                ]);

                $idUserDb = ($this->dbPerangkat['users']) ? $this->dbPerangkat['users']['id'] : null ; 
                $namaUserDb = ($this->dbPerangkat['users']) ? $this->dbPerangkat['users']['nama'] : null ; 
                $idPengirimanDb = ($this->dbPerangkat['pengiriman']) ? $this->dbPerangkat['pengiriman']['id'] : null ; 
                $noPengirimanDb = ($this->dbPerangkat['pengiriman']) ? $this->dbPerangkat['pengiriman']['no_pengiriman'] : null ; 

                LogPerangkat::create([
                    'id_perangkat' => $this->perangkatId,
                    'data_log' => [
                                    'aksi' => 'Edit',
                                    'browser' => $_SERVER['HTTP_USER_AGENT'],
                                    'edited_by' => session('nama'),
                                    'data_lama' =>  [
                                                        'sn_lama' => $this->dbPerangkat['sn_lama'],
                                                        'sn_pengganti' => $this->dbPerangkat['sn_pengganti'],
                                                        'sn_monitor' => $this->dbPerangkat['sn_monitor'],
                                                        'id_tipe' => $this->dbPerangkat['TipePerangkat']['id'],
                                                        'tipe' => $this->dbPerangkat['TipePerangkat']['kode_perangkat'],
                                                        'id_user' => $idUserDb,
                                                        'user' => $namaUserDb,
                                                        'id_sistem' => $this->dbPerangkat['tipeSistem']['id'],
                                                        'sistem' => $this->dbPerangkat['tipeSistem']['kode_sistem'],
                                                        'id_cabang' => $this->dbPerangkat['cabang']['id'],
                                                        'cabang' => $this->dbPerangkat['cabang']['nama_cabang'],
                                                        'id_pengiriman' => $idPengirimanDb,
                                                        'no_pengiriman' => $noPengirimanDb,
                                                        'ket' => $this->dbPerangkat['keterangan'],
                                                        'cek_status' => $this->dbPerangkat['cek_status'],
                                                        'perolehan' => $this->dbPerangkat['perolehan'],
                                                        'gelombang' => $this->dbPerangkat['gelombang'],
                                                    ],
                                    'data_baru' =>  [
                                                        'sn_lama' => strtoupper($this->sn_lama),
                                                        'sn_pengganti' => strtoupper($this->sn_pengganti),
                                                        'sn_monitor' => strtoupper($this->sn_monitor),
                                                        'id_tipe' => $newTipePerangkat['id'],
                                                        'tipe' => $newTipePerangkat['kode_perangkat'],
                                                        'id_user' => $getDataUser['id'],
                                                        'user' => $getDataUser['nama'],
                                                        'id_sistem' => $newTipeSistem['id'],
                                                        'sistem' => $newTipeSistem['kode_sistem'],
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
                return $this->addError('sn_lama', 'Sn Sudah ada');
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
        $this->reset();
    }

}
