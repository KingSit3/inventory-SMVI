<?php

namespace App\Http\Livewire\Perangkat;

use App\Models\ModelPengiriman as DoModel;
use App\Models\ModelTipeSistem as Image;
use App\Models\ModelLogPerangkat as LogPerangkat;
use App\Models\ModelLogUser as LogUser;
use App\Models\ModelPerangkat as ModelsPerangkat;
use App\Models\ModelGelombang as Gelombang;
use App\Models\ModelTipePerangkat as TipePerangkat;
use App\Models\ModelUser as User;
use App\Models\ModelCabang as Cabang;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Perangkat extends Component
{ 
    use WithPagination;
    public $tipePerangkat, $sn_lama, $sn_pengganti, 
    $sn_monitor, $imagePerangkat, $cekStatus, $perolehan, 
    $spPerangkat, $ket, $oldSnLama, $oldSnPengganti, 
    $oldSnMonitor, $dataLama;
    public $dbPerangkat, $perangkatId, $dbCabang, $dbUser;
    public $namaUser, $nikUser, $telpUser, $userSearch, $userId;
    public $witel, $witelSearch, $witelId;
    public $kodeDo, $doId, $doSearch;
    public $doData, $witelData, $userData = '';

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

        $hasilCabang = '';
        if (strlen($this->witelSearch) > 0) {
            $witelSearchQuery = '%'.$this->witelSearch.'%';
            $hasilCabang = Cabang::where('nama_witel', 'like', $witelSearchQuery)->limit(5)->get();
        }

        $hasilDo = '';
        if (strlen($this->doSearch) > 0) {
            $doSearchQuery = '%'.$this->doSearch.'%';
            $hasilDo = DoModel::where('no_do', 'like', $doSearchQuery)->limit(5)->get();
        }

        $data = [
            'doResult' => $hasilDo,
            'userResult' => $hasilUser,
            'witelResult' => $hasilCabang,
            'sp' => Gelombang::all()->sortDesc(),
            'image' => Image::all(),
            'tipe' => tipePerangkat::all(),
            'perangkatData' => ModelsPerangkat::with('users', 'witel', 'deliveryOrder', 'TipePerangkat', 'image')
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
        if ($this->sn_lama == null) {
            $this->sn_lama = null;
        }

        if ($this->doData == null) {
            $this->doData = ['id' => null, 'no_do' => null];
        }
        if ($this->witelData == null) {
            $this->witelData = ['id' => null, 'nama_witel' => null];
        }
        if ($this->userData == null) {
            $this->userData = ['id' => null, 'name' => null];
        }

        if ($this->imagePerangkat) {
            $dataImage = Image::where('id', $this->imagePerangkat)->first();
        } else {
            $dataImage = ['id' => null, 'kode_image' => null];
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
                'name' => $this->namaUser,
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
                    'id_image' => $this->imagePerangkat,
                    'id_witel' => $this->witelId,
                    'id_do' => $this->doId,
                    'keterangan' => $this->ket,
                    'cek_status' => $this->cekStatus,
                    'sp' => $this->spPerangkat,
                    'perolehan' => $this->perolehan,
                ]);

                // Ambil Id Perangkat terakhir
                $getLastPerangkat = ModelsPerangkat::latest()->first();
                LogPerangkat::create([
                    'id_perangkat' => $getLastPerangkat['id'],
                    'data_log' => [
                                    'aksi' => 'Tambah',
                                    'browser' => $_SERVER['HTTP_USER_AGENT'],
                                    'edited_by' => session('name'),
                                    'data_lama' =>  [],
                                    'data_baru' =>  [
                                                        'sn_lama' => $this->sn_lama,
                                                        'sn_pengganti' => $this->sn_pengganti,
                                                        'sn_monitor' => $this->sn_monitor,
                                                        'id_tipe' => $dataTipe['id'],
                                                        'tipe' => $dataTipe['kode_perangkat'],
                                                        'id_user' => $this->userData['id'],
                                                        'user' => $this->userData['name'],
                                                        'id_image' => $dataImage['id'],
                                                        'image' => $dataImage['kode_image'],
                                                        'id_witel' => $this->witelData['id'],
                                                        'witel' => $this->witelData['nama_witel'],
                                                        'id_delivery_order' => $this->doData['id'],
                                                        'delivery_order' => $this->doData['no_do'],
                                                        'ket' => $this->ket,
                                                        'cek_status' => $this->cekStatus,
                                                        'perolehan' => $this->perolehan,
                                                        'sp' => $this->spPerangkat,
                                                    ],
                                ],
                ]);

                LogUser::create([
                    'id_user' => $this->userId,
                    'data_log' => [
                                    'aksi' => 'Tambah',
                                    'browser' => $_SERVER['HTTP_USER_AGENT'],
                                    'edited_by' => session('name'),
                                    'data_lama' =>  [],
                                    'data_baru' =>  [
                                                        'name' => $getLastUser['name'],
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
                    'id_image' => $this->imagePerangkat,
                    'id_witel' => $this->witelId,
                    'id_do' => $this->doId,
                    'keterangan' => $this->ket,
                    'cek_status' => $this->cekStatus,
                    'sp' => $this->spPerangkat,
                    'perolehan' => $this->perolehan,
                ]);

                $getLastPerangkat = ModelsPerangkat::latest()->first();
                LogPerangkat::create([
                    'id_perangkat' => $getLastPerangkat['id'],
                    'data_log' => [
                                    'aksi' => 'Tambah',
                                    'browser' => $_SERVER['HTTP_USER_AGENT'],
                                    'edited_by' => session('name'),
                                    'data_lama' =>  [],
                                    'data_baru' =>  [
                                                        'sn_lama' => $this->sn_lama,
                                                        'sn_pengganti' => $this->sn_pengganti,
                                                        'sn_monitor' => $this->sn_monitor,
                                                        'id_tipe' => $dataTipe['id'],
                                                        'tipe' => $dataTipe['kode_perangkat'],
                                                        'id_user' => $this->userData['id'],
                                                        'user' => $this->userData['name'],
                                                        'id_image' => $dataImage['id'],
                                                        'image' => $dataImage['kode_image'],
                                                        'id_witel' => $this->witelData['id'],
                                                        'witel' => $this->witelData['nama_witel'],
                                                        'id_delivery_order' => $this->doData['id'],
                                                        'delivery_order' => $this->doData['no_do'],
                                                        'ket' => $this->ket,
                                                        'cek_status' => $this->cekStatus,
                                                        'perolehan' => $this->perolehan,
                                                        'sp' => $this->spPerangkat,
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
        $getDataImage = Image::where('id', $getDataPerangkat['id_image'])->withTrashed()->first();

        // get User
        if ($getDataPerangkat['id_user']) {
            $getDataUser = User::where('id', $getDataPerangkat['id_user'])->withTrashed()->first();
        } else {
            $getDataUser = ['id' => null, 'name' => null];
        }

        // Get Cabang
        if ($getDataPerangkat['id_witel']) {
            $getDataCabang = Cabang::where('id', $getDataPerangkat['id_witel'])->withTrashed()->first();
        } else {
            $getDataCabang = ['id' => null, 'nama_witel' => null];
        }

        // Get DO
        if ($getDataPerangkat['id_do']) {
            $getDataDo = DoModel::where('id', $getDataPerangkat['id_do'])->withTrashed()->first();
        } else {
            $getDataDo = ['id' => null, 'no_do' => null];
        }

        LogPerangkat::create([
            'id_perangkat' => $id,
            'data_log' => [
                            'aksi' => 'Hapus',
                            'browser' => $_SERVER['HTTP_USER_AGENT'],
                            'edited_by' => session('name'),
                            'data_lama' =>  [
                                                'sn_lama' => $getDataPerangkat['sn_lama'],
                                                'sn_pengganti' => $getDataPerangkat["sn_pengganti"],
                                                'sn_monitor' => $getDataPerangkat['sn_monitor'],
                                                'id_tipe' => $getDataTipe['id'],
                                                'tipe' => $getDataTipe['kode_perangkat'],
                                                'id_user' => $getDataUser['id'],
                                                'user' => $getDataUser['name'],
                                                'id_image' => $getDataImage['id'],
                                                'image' => $getDataImage['kode_image'],
                                                'id_witel' => $getDataCabang['id'],
                                                'witel' => $getDataCabang['nama_witel'],
                                                'id_delivery_order' => $getDataDo['id'],
                                                'delivery_order' => $getDataDo['no_do'],
                                                'ket' => $getDataPerangkat['keterangan'],
                                                'cek_status' => $getDataPerangkat['cek_status'],
                                                'perolehan' => $getDataPerangkat['perolehan'],
                                                'sp' => $getDataPerangkat['sp'],
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
            $this->namaUser = $this->dbUser['name'];
            $this->nikUser = $this->dbUser['nik'];
            $this->telpUser = $this->dbUser['no_telp'];
            $this->userId = $this->dbPerangkat['id_user'];
        }

        if ($this->dbPerangkat['id_witel'] != null) {
            
            $this->dbCabang = Cabang::where('id', $this->dbPerangkat['id_witel'])->withTrashed()->first();
            $this->witel = $this->dbCabang['nama_witel'];
            $this->witelId = $this->dbCabang['id_witel'];
        }

        if ($this->dbPerangkat['id_do'] != null) {

            $dbDo = DoModel::where('id', $this->dbPerangkat['id_do'])->withTrashed()->first();
            $this->doId = $this->dbPerangkat['id_do'];
            $this->kodeDo = $dbDo['no_do'];
        }

        // $this->dbTipePerangkat = tipePerangkat::where('id', $this->dbPerangkat['id_tipe'])->withTrashed()->first();
        $this->oldSnLama = $this->dbPerangkat['sn_lama'];
        $this->oldSnPengganti = $this->dbPerangkat['sn_pengganti'];
        $this->oldSnMonitor = $this->dbPerangkat['sn_monitor'];

        $this->sn_lama = $this->dbPerangkat['sn_lama'];
        $this->tipePerangkat = $this->dbPerangkat['id_tipe'];
        $this->sn_pengganti = $this->dbPerangkat['sn_pengganti'];
        $this->sn_monitor = $this->dbPerangkat['sn_monitor'];
        $this->imagePerangkat = $this->dbPerangkat['id_image'];
        
        $this->ket = $this->dbPerangkat['keterangan'];
        $this->cekStatus = $this->dbPerangkat['cek_status'];
        $this->spPerangkat = $this->dbPerangkat['sp'];
        $this->perolehan = $this->dbPerangkat['perolehan'];

        // untuk Log
        $getDataTipe = tipePerangkat::where('id', $this->dbPerangkat['id_tipe'])->withTrashed()->first();
        $getDataImage = Image::where('id', $this->dbPerangkat['id_image'])->withTrashed()->first();

        // get User
        if ($this->dbPerangkat['id_user']) {
            $getDataUser = User::where('id', $this->dbPerangkat['id_user'])->withTrashed()->first();
        } else {
            $getDataUser = ['id' => null, 'name' => null];
        }

        // Get Cabang
        if ($this->dbPerangkat['id_witel']) {
            $getDataCabang = Cabang::where('id', $this->dbPerangkat['id_witel'])->withTrashed()->first();
        } else {
            $getDataCabang = ['id' => null, 'nama_witel' => null];
        }

        // Get DO
        if ($this->dbPerangkat['id_do']) {
            $getDataDo = DoModel::where('id', $this->dbPerangkat['id_do'])->withTrashed()->first();
        } else {
            $getDataDo = ['id' => null, 'no_do' => null];
        }

        $this->dataLama = [
            'sn_lama' => $this->dbPerangkat['sn_lama'],
            'sn_pengganti' => $this->dbPerangkat['sn_pengganti'],
            'sn_monitor' => $this->dbPerangkat['sn_monitor'],
            'id_tipe' => $this->dbPerangkat['id_tipe'],
            'tipe' => $getDataTipe['kode_perangkat'],
            'id_user' => $this->dbPerangkat['id_user'],
            'user' => $getDataUser['name'],
            'id_image' => $this->dbPerangkat['id_image'],
            'image' => $getDataImage['kode_image'],
            'id_witel' => $this->dbPerangkat['id_witel'],
            'witel' => $getDataCabang['nama_witel'],
            'id_delivery_order' => $this->dbPerangkat['id_do'],
            'delivery_order' => $getDataDo['no_do'],
            'ket' => $this->dbPerangkat['keterangan'],
            'cek_status' => $this->dbPerangkat['cek_status'],
            'perolehan' => $this->dbPerangkat['perolehan'],
            'sp' => $this->dbPerangkat['sp'],
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
            // 'sn_lama' => ['unique:App\Models\Perangkat,sn_lama,'.$this->sn_lama, 'nullable'],
            'tipePerangkat' => 'required',
            'sn_pengganti' => [Rule::unique('perangkat', 'sn_pengganti')->ignore($this->oldSnPengganti, 'sn_pengganti')],
            'sn_monitor' => [Rule::unique('perangkat', 'sn_monitor')->ignore($this->oldSnMonitor, 'sn_monitor'), 'nullable'],
            'nikUser' => $nikValidate,
            'imagePerangkat' => 'required',
        ]);

        $getDataTipe = tipePerangkat::where('id', $this->tipePerangkat)->withTrashed()->first();
        $getDataImage = Image::where('id', $this->imagePerangkat)->withTrashed()->first();

        // Get Cabang
        if ($this->witelId) {
            $getDataCabang = Cabang::where('id', $this->witelId)->withTrashed()->first();
        } else {
            $getDataCabang = ['id' => null, 'nama_witel' => null];
        }

        // get User
        if ($this->userId) {
            $getDataUser = User::where('id', $this->userId)->withTrashed()->first();
        } else {
            $getDataUser = ['id' => null, 'name' => null];
        }

        // Get DO
        if ($this->doId) {
            $getDataDo = DoModel::where('id', $this->doId)->withTrashed()->first();
        } else {
            $getDataDo = ['id' => null, 'no_do' => null];
        }

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

                // get User
                if ($this->userId) {
                    $getDataUser = User::where('id', $this->userId)->withTrashed()->first();
                } else {
                    $getDataUser = ['id' => null, 'name' => null];
                }

                ModelsPerangkat::where('id', $this->perangkatId)->update([
                    'sn_lama' => $this->sn_lama,
                    'id_tipe' => $this->tipePerangkat,
                    'sn_pengganti' => $this->sn_pengganti,
                    'sn_monitor' => $this->sn_monitor,
                    'id_user' => $this->userId,
                    'id_image' => $this->imagePerangkat,
                    'id_witel' => $this->witelId,
                    'id_do' => $this->doId,
                    'keterangan' => $this->ket,
                    'cek_status' => $this->cekStatus,
                    'sp' => $this->spPerangkat,
                    'perolehan' => $this->perolehan,
                ]);

                LogPerangkat::create([
                    'id_perangkat' => $this->perangkatId,
                    'data_log' => [
                                    'aksi' => 'Edit',
                                    'browser' => $_SERVER['HTTP_USER_AGENT'],
                                    'edited_by' => session('name'),
                                    'data_lama' =>  [
                                                        'sn_lama' => $this->dataLama['sn_lama'],
                                                        'sn_pengganti' => $this->dataLama['sn_pengganti'],
                                                        'sn_monitor' => $this->dataLama['sn_monitor'],
                                                        'id_tipe' => $this->dataLama['id_tipe'],
                                                        'tipe' => $this->dataLama['tipe'],
                                                        'id_user' => $this->dataLama['id_user'],
                                                        'user' => $this->dataLama['user'],
                                                        'id_image' => $this->dataLama['id_image'],
                                                        'image' => $this->dataLama['image'],
                                                        'id_witel' => $this->dataLama['id_witel'],
                                                        'witel' => $this->dataLama['witel'],
                                                        'id_delivery_order' => $this->dataLama['id_delivery_order'],
                                                        'delivery_order' => $this->dataLama['delivery_order'],
                                                        'ket' => $this->dataLama['ket'],
                                                        'cek_status' => $this->dataLama['cek_status'],
                                                        'perolehan' => $this->dataLama['perolehan'],
                                                        'sp' => $this->dataLama['sp'],
                                                    ],
                                    'data_baru' =>  [
                                                        'sn_lama' => $this->sn_lama,
                                                        'sn_pengganti' => $this->sn_pengganti,
                                                        'sn_monitor' => $this->sn_monitor,
                                                        'id_tipe' => $getDataTipe['id'],
                                                        'tipe' => $getDataTipe['kode_perangkat'],
                                                        'id_user' => $getDataUser['id'],
                                                        'user' => $getDataUser['name'],
                                                        'id_image' => $getDataImage['id'],
                                                        'image' => $getDataImage['kode_image'],
                                                        'id_witel' => $getDataCabang['id'],
                                                        'witel' => $getDataCabang['nama_witel'],
                                                        'id_delivery_order' => $getDataDo['id'],
                                                        'delivery_order' => $getDataDo['no_do'],
                                                        'ket' => $this->ket,
                                                        'cek_status' => $this->cekStatus,
                                                        'perolehan' => $this->perolehan,
                                                        'sp' => $this->spPerangkat,
                                                    ],
                                ],
                ]);

                LogUser::create([
                    'id_user' => $this->userId,
                    'data_log' => [
                                    'aksi' => 'Tambah',
                                    'browser' => $_SERVER['HTTP_USER_AGENT'],
                                    'edited_by' => session('name'),
                                    'data_lama' =>  [],
                                    'data_baru' =>  [
                                                        'name' => $getLastUser['name'],
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
                    'id_image' => $this->imagePerangkat,
                    'id_witel' => $this->witelId,
                    'id_do' => $this->doId,
                    'keterangan' => $this->ket,
                    'cek_status' => $this->cekStatus,
                    'sp' => $this->spPerangkat,
                    'perolehan' => $this->perolehan,
                ]);

                LogPerangkat::create([
                    'id_perangkat' => $this->perangkatId,
                    'data_log' => [
                                    'aksi' => 'Edit',
                                    'browser' => $_SERVER['HTTP_USER_AGENT'],
                                    'edited_by' => session('name'),
                                    'data_lama' =>  [
                                                        'sn_lama' => $this->dataLama['sn_lama'],
                                                        'sn_pengganti' => $this->dataLama['sn_pengganti'],
                                                        'sn_monitor' => $this->dataLama['sn_monitor'],
                                                        'id_tipe' => $this->dataLama['id_tipe'],
                                                        'tipe' => $this->dataLama['tipe'],
                                                        'id_user' => $this->dataLama['id_user'],
                                                        'user' => $this->dataLama['user'],
                                                        'id_image' => $this->dataLama['id_image'],
                                                        'image' => $this->dataLama['image'],
                                                        'id_witel' => $this->dataLama['id_witel'],
                                                        'witel' => $this->dataLama['witel'],
                                                        'id_delivery_order' => $this->dataLama['id_delivery_order'],
                                                        'delivery_order' => $this->dataLama['delivery_order'],
                                                        'ket' => $this->dataLama['ket'],
                                                        'cek_status' => $this->dataLama['cek_status'],
                                                        'perolehan' => $this->dataLama['perolehan'],
                                                        'sp' => $this->dataLama['sp'],
                                                    ],
                                    'data_baru' =>  [
                                                        'sn_lama' => $this->sn_lama,
                                                        'sn_pengganti' => $this->sn_pengganti,
                                                        'sn_monitor' => $this->sn_monitor,
                                                        'id_tipe' => $getDataTipe['id'],
                                                        'tipe' => $getDataTipe['kode_perangkat'],
                                                        'id_user' => $getDataUser['id'],
                                                        'user' => $getDataUser['name'],
                                                        'id_image' => $getDataImage['id'],
                                                        'image' => $getDataImage['kode_image'],
                                                        'id_witel' => $getDataCabang['id'],
                                                        'witel' => $getDataCabang['nama_witel'],
                                                        'id_delivery_order' => $getDataDo['id'],
                                                        'delivery_order' => $getDataDo['no_do'],
                                                        'ket' => $this->ket,
                                                        'cek_status' => $this->cekStatus,
                                                        'perolehan' => $this->perolehan,
                                                        'sp' => $this->spPerangkat,
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
      $this->namaUser = $this->userData['name'];
      $this->nikUser = $this->userData['nik'];
      $this->telpUser = $this->userData['no_telp'];
      $this->reset('userSearch');
    }

    public function chooseCabang($id) 
    {
        $this->witelData = Cabang::where('id', $id)->first();
        $this->witelId = $id;
        $this->witel = $this->witelData['kode_witel'].' | '.$this->witelData['nama_witel'];
        $this->reset('witelSearch');
    }

    public function chooseDo($id) 
    {
        $this->doData = DoModel::where('id', $id)->first();
        $this->doId = $id;
        $this->kodeDo = $this->doData['no_do'];
        $this->reset('doSearch');
    }

    public function resetData() 
    {
        $this->addUser = false;
        // Reset Validasi
        $this->resetValidation();
        // Reset input field
        // $this->reset('submitType', 'tipePerangkat', 'userSearch', 'witelSearch', 'doSearch', 'sn_lama', 'sn_pengganti', 'sn_monitor', 'imagePerangkat', 'witel', 'witelId', 'kodeDo', 'spPerangkat', 'cekStatus', 'perolehan', 'ket', 'namaUser', 'nikUser', 'telpUser', 'doId');
        $this->reset();
    }

}
