<?php

namespace App\Http\Livewire\Cabang;

use App\Models\ModelLogUser as LogUser;
use App\Models\ModelLogCabang;
use App\Models\ModelUser;
use App\Models\ModelCabang;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Cabang extends Component
{
    use WithPagination;
    public  $idCabang, $dbCabang, $submitType, $nama, 
            $kode, $regional, $alamat, $keyword, $oldDataCabang;
    public $picNik, $picId, $no_telp, $picName, $picSearch, $dbUser, $oldNik, $oldDataUser;
    public $isOpen, $addNewPic = false;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
      $keyword = '%'.$this->keyword.'%';

      $picQuery = '';
      $picSearch = '%'.$this->picSearch.'%';
      if (strlen($this->picSearch) > 0) {
        $picQuery = ModelUser::where('nama', 'like', $picSearch)->limit(5)->get();
        $this->addNewPic = false;
      } 

        $data = [
            // Joins using Relationship
            'cabang' => ModelCabang::with('users')->where('nama_cabang', 'like', $keyword)
                                                ->orWhere('kode_cabang', 'like', $keyword)
                                                ->paginate(10),
            'pic' => $picQuery,
        ];

        return view('livewire.cabang.cabang', $data)
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
          'regional' => 'nullable|numeric',
          'picName' => 'required',
          'picNik' => ['numeric', 'nullable', Rule::unique('users', 'nik')->ignore($this->picNik, 'nik')],
          'kode' => 'unique:App\Models\ModelCabang,kode_cabang',
          'no_telp' => 'nullable',
        ],
      );

      if ($this->addNewPic == true) {

        try {
          $saveUser = ModelUser::create([
            'nama' => $this->picName,
            'nik' => (trim($this->picNik) == '') ? null : $this->picNik,
            'no_telp' => $this->no_telp,
          ]);

          // Ambil id user terakhir
          $this->picId = $saveUser->id;
          $getLastUser = ModelUser::where('id', $saveUser->id)->first();
  
          ModelCabang::create([
            'nama_cabang' => $this->nama,
            'kode_cabang' => $this->kode,
            'regional' => $this->regional,
            'alamat_cabang' => $this->alamat,
            'id_pic' => $this->picId,
          ]);

          $getIdCabang = ModelCabang::latest()->first();
          ModelLogCabang::create([
            'id_cabang' => $getIdCabang['id'],
            'data_log' => [
                          'aksi' => 'Tambah',
                          'browser' => $_SERVER['HTTP_USER_AGENT'],
                          'edited_by' => session('nama'),
                          'data_lama' =>  [],
                          'data_baru' =>  [
                                              'nama_cabang' => $this->nama,
                                              'kode_cabang' => $this->kode,
                                              'alamat_cabang' => $this->alamat,
                                              'regional' => $this->regional,
                                              'id_pic' => $this->picId,
                                              'nama_pic' => $getLastUser['nama'],
                                          ],
                            ],
          ]);

          LogUser::create([
            'id_user' => $this->picId,
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

        }catch (\Exception $ex) {
          return $this->addError('picNik', 'Nik Sudah terdaftar');
        }
        
      } else {
        try {
          // Tambah data Cabang
          ModelCabang::create([
            'nama_cabang' => $this->nama,
            'kode_cabang' => $this->kode,
            'regional' => $this->regional,
            'alamat_cabang' => $this->alamat,
            'id_pic' => $this->picId,
          ]);

          $getUser = ModelUser::where('id', $this->picId)->first();
          $getIdCabang = ModelCabang::latest()->first();
          ModelLogCabang::create([
            'id_cabang' => $getIdCabang['id'],
            'data_log' => [
                          'aksi' => 'Tambah',
                          'browser' => $_SERVER['HTTP_USER_AGENT'],
                          'edited_by' => session('nama'),
                          'data_lama' =>  [],
                          'data_baru' =>  [
                                              'nama_cabang' => $this->nama,
                                              'kode_cabang' => $this->kode,
                                              'alamat_cabang' => $this->alamat,
                                              'regional' => $this->regional,
                                              'id_pic' => $this->picName,
                                              'nama_pic' => $getUser['nama'],
                                          ],
                            ],
          ]);

        } catch (\Exception $ex) {
          return $this->addError('picName', 'PIC Sudah ada di Cabang lain');
        }
      }

      // Panggil fungsi Reset data
      $this->resetData();

      // Tutup Modal
      $this->isOpen = false;
      $this->addNewPic = false;

      // Panggil SweetAlert berhasil
      $this->emit('success', 'Data Cabang Berhasil Ditambahkan');

    }

    public function edit($id) 
    {
      $this->submitType = 'update';
      $this->dbCabang = ModelCabang::where('id', $id)->first();
      $this->dbUser = ModelUser::where('id', $this->dbCabang['id_pic'])->withTrashed()->first();

      $this->idCabang = $id;
      // Value input
      $this->nama = $this->dbCabang['nama_cabang'];
      $this->kode = $this->dbCabang['kode_cabang'];
      $this->regional = $this->dbCabang['regional'];
      $this->alamat = $this->dbCabang['alamat_cabang'];

      $this->oldNik = $this->dbUser['nik'];
      $this->picNik = $this->dbUser['nik'];
      $this->picName = $this->dbUser['nama'];
      $this->no_telp = $this->dbUser['no_telp'];

      $this->oldDataCabang = ModelCabang::where('id', $id)->first();
      $this->oldDataUser = ModelUser::where('id', $this->dbCabang['id_pic'])->withTrashed()->first();
    }

    public function update() 
    {
      $this->validate(
        // Rules
        [
          'regional' => 'nullable|numeric',
          'picName' => 'required',
          'picNik' => ['numeric', 'nullable', Rule::unique('users', 'nik')->ignore($this->oldNik, 'nik')],
          'kode' => [Rule::unique('cabang', 'kode_cabang')->ignore($this->kode, 'kode_cabang')],
          'no_telp' => 'nullable',
        ]
      );

      if ($this->addNewPic == true) {
        // Tambah data user + Cabang

        try {
          $saveUser = ModelUser::create([
            'nama' => $this->picName,
            'nik' => (trim($this->picNik) == '') ? null : $this->picNik,
            'no_telp' => $this->no_telp,
          ]);

          // Ambil id user terakhir
          $this->picId = $saveUser->id;
          $getLastUser = ModelUser::where('id', $saveUser->id)->first();
  
          ModelCabang::where('id', $this->idCabang)->update([
            'nama_cabang' => $this->nama,
            'kode_cabang' => $this->kode,
            'regional' => $this->regional,
            'alamat_cabang' => $this->alamat,
            'id_pic' => $this->picId,
          ]);

          ModelLogCabang::create([
            'id_cabang' => $this->idCabang,
            'data_log' => [
                          'aksi' => 'Edit',
                          'browser' => $_SERVER['HTTP_USER_AGENT'],
                          'edited_by' => session('nama'),
                          'data_lama' =>  [
                                              'nama_cabang' => $this->oldDataCabang['nama_cabang'],
                                              'kode_cabang' => $this->oldDataCabang['kode_cabang'],
                                              'alamat_cabang' => $this->oldDataCabang['alamat_cabang'],
                                              'regional' => $this->oldDataCabang['regional'],
                                              'id_pic' => $this->oldDataUser['id'],
                                              'nama_pic' => $this->oldDataUser['nama'],
                                          ],
                          'data_baru' =>  [
                                              'nama_cabang' => $this->nama,
                                              'kode_cabang' => $this->kode,
                                              'alamat_cabang' => $this->alamat,
                                              'regional' => $this->regional,
                                              'id_pic' => $this->picId,
                                              'nama_pic' => $getLastUser['nama'],
                                          ],
                            ],
          ]);

          LogUser::create([
            'id_user' => $this->picId,
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

        }catch (\Exception $ex) {
          return $ex;
          // return $this->addError('picNik', 'Nik Sudah terdaftar');
        }
        
      } else {
        try {
          // Ubah data Cabang
          ModelCabang::where('id', $this->idCabang)->update([
            'nama_cabang' => $this->nama,
            'kode_cabang' => $this->kode,
            'regional' => $this->regional,
            'alamat_cabang' => $this->alamat,
          ]);

        ModelLogCabang::create([
          'id_cabang' => $this->idCabang,
          'data_log' => [
                        'aksi' => 'Edit',
                        'browser' => $_SERVER['HTTP_USER_AGENT'],
                        'edited_by' => session('nama'),
                        'data_lama' =>  [
                                            'nama_cabang' => $this->oldDataCabang['nama_cabang'],
                                            'kode_cabang' => $this->oldDataCabang['kode_cabang'],
                                            'alamat_cabang' => $this->oldDataCabang['alamat_cabang'],
                                            'regional' => $this->oldDataCabang['regional'],
                                            'id_pic' => $this->oldDataUser['id'],
                                            'nama_pic' => $this->oldDataUser['nama'],
                                        ],
                        'data_baru' =>  [
                                            'nama_cabang' => $this->nama,
                                            'kode_cabang' => $this->kode,
                                            'alamat_cabang' => $this->alamat,
                                            'regional' => $this->regional,
                                            'id_pic' => $this->picId,
                                            'nama_pic' => $this->picName,
                                        ],
                          ],
        ]);
            
        } catch (\Exception $ex) {
          return $this->addError('kode', 'Kode Cabang Sudah ada');
        }
      }

      // Panggil fungsi Reset data
      $this->resetData();

      // Tutup Modal
      $this->isOpen = false;
      $this->addNewPic = false;

      // Panggil SweetAlert berhasil
      $this->emit('success', 'Data Cabang Berhasil Ditambahkan');

    }

    public function addPic()
    {
        $this->addNewPic = true;
        $this->reset('picName', 'picNik', 'no_telp', 'picSearch');
    }

    public function choosePic($id) 
    {
      $picData = ModelUser::where('id', $id)->first();
      $this->picId = $id;
      $this->picName = $picData['nama'];
      $this->picNik = $picData['nik'];
      $this->no_telp = $picData['no_telp'];
      $this->reset('picSearch');
    }

    public function delete($id)
    {
      $cabangQuery = ModelCabang::where('id', $id)->first();
      $cabangQuery->delete();

      $dataUser  = ModelUser::where('id', $cabangQuery['id_pic'])->first();
      ModelLogCabang::create([
        'id_cabang' => $id,
        'data_log' => [
                      'aksi' => 'Hapus',
                      'browser' => $_SERVER['HTTP_USER_AGENT'],
                      'edited_by' => session('nama'),
                      'data_lama' =>  [
                                          'nama_cabang' => $cabangQuery['nama_cabang'],
                                          'kode_cabang' => $cabangQuery['kode_cabang'],
                                          'alamat_cabang' => $cabangQuery['alamat_cabang'],
                                          'regional' => $cabangQuery['regional'],
                                          'id_pic' => $dataUser['id'],
                                          'nama_pic' => $dataUser['nama'],
                                      ],
                      'data_baru' =>  [],
                        ],
      ]);
    }

    public function resetData()
    {
        // Reset Validasi
        $this->resetValidation();
        // Reset input field
        $this->reset();
    }
}
