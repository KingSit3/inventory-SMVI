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
            $kode, $regional, $alamat, $keyword;
    public $picNik, $picId, $no_telp, $picName, $picSearch = null;
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

      if ($this->addNewPic == true) {
        $nikValidate = ['numeric', 'nullable', Rule::unique('users', 'nik')->ignore($this->picNik, 'nik')];
      } else {
          $nikValidate = '';
      }

      $this->validate(
        // Rules
        [
          'regional' => 'nullable|numeric',
          'picName' => 'required|max:100',
          'picNik' => $nikValidate,
          'kode' => 'unique:App\Models\ModelCabang,kode_cabang',
          'no_telp' => 'nullable|max:50',
        ],
      );

      if ($this->addNewPic == true) {

        try {
          $saveUser = ModelUser::create([
            'nama' => $this->picName,
            'nik' => (trim($this->picNik) == '') ? null : $this->picNik,
            'no_telp' => $this->no_telp,
          ]);

          $saveCabang = ModelCabang::create([
            'nama_cabang' => $this->nama,
            'kode_cabang' => $this->kode,
            'regional' => $this->regional,
            'alamat_cabang' => $this->alamat,
            'id_pic' => $saveUser->id,
          ]);

          ModelLogCabang::create([
            'id_cabang' => $saveCabang->id,
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
                                              'id_pic' => $saveUser->id,
                                              'nama_pic' => $saveUser->nama,
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

        }catch (\Exception $ex) {
          return $this->addError('picNik', 'Nik Sudah terdaftar');
        }
        
      } else {
        try {
          // Tambah data Cabang
          $saveCabang = ModelCabang::create([
            'nama_cabang' => $this->nama,
            'kode_cabang' => $this->kode,
            'regional' => $this->regional,
            'alamat_cabang' => $this->alamat,
            'id_pic' => $this->picId,
          ]);

          ModelLogCabang::create([
            'id_cabang' => $saveCabang->id,
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
                                              'nama_pic' => $this->picName,
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
      $this->dbCabang = ModelCabang::with('users')->where('id', $id)->first();

      $this->idCabang = $id;
      $this->picId = $this->dbCabang['id_pic'];

      // Value input
      $this->nama = $this->dbCabang['nama_cabang'];
      $this->kode = $this->dbCabang['kode_cabang'];
      $this->regional = $this->dbCabang['regional'];
      $this->alamat = $this->dbCabang['alamat_cabang'];

      $this->picNik = $this->dbCabang['users']['nik'];
      $this->picName = $this->dbCabang['users']['nama'];
      $this->no_telp = $this->dbCabang['users']['no_telp'];
    }

    public function update() 
    {
      if ($this->addNewPic == true) {
        $nikValidate = ['numeric', 'nullable', Rule::unique('users', 'nik')->ignore($this->dbCabang['users']['nik'], 'nik')];
      } else {
          $nikValidate = '';
      }

      $this->validate(
        // Rules
        [
          'regional' => 'nullable|numeric',
          'picName' => 'required|max:100',
          'picNik' => $nikValidate,
          'kode' => [Rule::unique('cabang', 'kode_cabang')->ignore($this->kode, 'kode_cabang')],
          'no_telp' => 'nullable|max:50',
        ]
      );
      

      if ($this->addNewPic == true) {
        // Tambah data user
        try {
          $saveUser = ModelUser::create([
            'nama' => $this->picName,
            'nik' => (trim($this->picNik) == '') ? null : $this->picNik,
            'no_telp' => $this->no_telp,
          ]);

          ModelCabang::where('id', $this->idCabang)->update([
            'nama_cabang' => $this->nama,
            'kode_cabang' => $this->kode,
            'regional' => $this->regional,
            'alamat_cabang' => $this->alamat,
            'id_pic' => $saveUser->id,
          ]);

          ModelLogCabang::create([
            'id_cabang' => $this->idCabang,
            'data_log' => [
                          'aksi' => 'Edit',
                          'browser' => $_SERVER['HTTP_USER_AGENT'],
                          'edited_by' => session('nama'),
                          'data_lama' =>  [
                                              'nama_cabang' => $this->dbCabang['nama_cabang'],
                                              'kode_cabang' => $this->dbCabang['kode_cabang'],
                                              'alamat_cabang' => $this->dbCabang['alamat_cabang'],
                                              'regional' => $this->dbCabang['regional'],
                                              'id_pic' => $this->dbCabang['users']['id'],
                                              'nama_pic' => $this->dbCabang['users']['nama'],
                                          ],
                          'data_baru' =>  [
                                              'nama_cabang' => $this->nama,
                                              'kode_cabang' => $this->kode,
                                              'alamat_cabang' => $this->alamat,
                                              'regional' => $this->regional,
                                              'id_pic' => $saveUser->id,
                                              'nama_pic' => $saveUser->nama,
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

        }catch (\Exception $ex) {
          // throw $ex;
          return $this->addError('picNik', 'Nik Sudah terdaftar');
        }
        
      } else {
        try {
          
          // Ubah data Cabang
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
                                              'nama_cabang' => $this->dbCabang['nama_cabang'],
                                              'kode_cabang' => $this->dbCabang['kode_cabang'],
                                              'alamat_cabang' => $this->dbCabang['alamat_cabang'],
                                              'regional' => $this->dbCabang['regional'],
                                              'id_pic' => $this->dbCabang['users']['id'],
                                              'nama_pic' => $this->dbCabang['users']['nama'],
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
          // throw $ex;
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
      $cabangQuery = ModelCabang::with('users')->where('id', $id)->first();
      $cabangQuery->delete();

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
                                          'id_pic' => $cabangQuery['users']['id'],
                                          'nama_pic' => $cabangQuery['users']['nama'],
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
