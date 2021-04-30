<?php

namespace App\Http\Livewire\Witel;

use App\Models\LogWitel;
use App\Models\User as ModelUser;
use App\Models\Witel as ModelsWitel;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Witel extends Component
{
    use WithPagination;
    public  $idWitel, $dbWitel, $submitType, $nama, 
            $kode, $regional, $alamat, $keyword, $oldDataWitel;
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
        $picQuery = ModelUser::where('name', 'like', $picSearch)->limit(5)->get();
        $this->addNewPic = false;
      } 

        $data = [
            // Joins using Relationship
            'witel' => ModelsWitel::with('Users')
                      ->where('nama_witel', 'like', $keyword)
                      ->orWhere('kode_witel', 'like', $keyword)
                      ->paginate(10),
            'pic' => $picQuery,
        ];

        return view('livewire.witel.witel', $data)
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
          'kode' => 'unique:App\Models\Witel,kode_witel',
          'no_telp' => 'nullable',
        ],
      );

      if ($this->addNewPic == true) {
        // Tambah data user + witel

        try {

          ModelUser::create([
            'name' => $this->picName,
            'nik' => $this->picNik,
            'no_telp' => $this->no_telp,
          ]);

          // Ambil id user terakhir
          $getLastUser = ModelUser::latest()->first();
          $this->picId = $getLastUser['id'];
  
          ModelsWitel::create([
            'nama_witel' => $this->nama,
            'kode_witel' => $this->kode,
            'regional' => $this->regional,
            'alamat_witel' => $this->alamat,
            'id_pic' => $this->picId,
          ]);

          $getIdWitel = ModelsWitel::latest()->first();

          LogWitel::create([
            'id_witel' => $getIdWitel['id'],
            'data_log' => [
                          'aksi' => 'Tambah',
                          'browser' => $_SERVER['HTTP_USER_AGENT'],
                          'edited_by' => session('name'),
                          'data_lama' =>  [],
                          'data_baru' =>  [
                                              'nama_witel' => $this->nama,
                                              'kode_witel' => $this->kode,
                                              'alamat_witel' => $this->alamat,
                                              'regional_witel' => $this->regional,
                                              'id_pic' => $this->picId,
                                              'nama_pic' => $getLastUser['name'],
                                          ],
                            ],
          ]);

        }catch (\Exception $ex) {
          return $this->addError('picNik', 'Nik Sudah terdaftar');
        }
        
      } else {
        try {
          // Tambah data witel
          ModelsWitel::create([
            'nama_witel' => $this->nama,
            'kode_witel' => $this->kode,
            'regional' => $this->regional,
            'alamat_witel' => $this->alamat,
            'id_pic' => $this->picId,
          ]);

          $getUser = ModelUser::where('id', $this->picId)->first();
          $getIdWitel = ModelsWitel::latest()->first();
          LogWitel::create([
            'id_witel' => $getIdWitel['id'],
            'data_log' => [
                          'aksi' => 'Tambah',
                          'browser' => $_SERVER['HTTP_USER_AGENT'],
                          'edited_by' => session('name'),
                          'data_lama' =>  [],
                          'data_baru' =>  [
                                              'nama_witel' => $this->nama,
                                              'kode_witel' => $this->kode,
                                              'alamat_witel' => $this->alamat,
                                              'regional_witel' => $this->regional,
                                              'id_pic' => $this->picName,
                                              'nama_pic' => $getUser['name'],
                                          ],
                            ],
          ]);

        } catch (\Exception $ex) {
          return $this->addError('picName', 'PIC Sudah ada di Witel lain');
        }
      }

      // Panggil fungsi Reset data
      $this->resetData();

      // Tutup Modal
      $this->isOpen = false;
      $this->addNewPic = false;

      // Panggil SweetAlert berhasil
      $this->emit('success', 'Data Witel Berhasil Ditambahkan');

    }

    public function edit($id) 
    {
      $this->submitType = 'update';
      $this->dbWitel = ModelsWitel::where('id', $id)->first();
      $this->dbUser = ModelUser::where('id', $this->dbWitel['id_pic'])->withTrashed()->first();

      $this->idWitel = $id;
      // Value input
      $this->nama = $this->dbWitel['nama_witel'];
      $this->kode = $this->dbWitel['kode_witel'];
      $this->regional = $this->dbWitel['regional'];
      $this->alamat = $this->dbWitel['alamat_witel'];

      $this->oldNik = $this->dbUser['nik'];
      $this->picNik = $this->dbUser['nik'];
      $this->picName = $this->dbUser['name'];
      $this->no_telp = $this->dbUser['no_telp'];

      $this->oldDataWitel = ModelsWitel::where('id', $id)->first();
      $this->oldDataUser = ModelUser::where('id', $this->dbWitel['id_pic'])->withTrashed()->first();
    }

    public function update() 
    {
      $this->validate(
        // Rules
        [
          'regional' => 'nullable|numeric',
          'picName' => 'required',
          'picNik' => ['numeric', 'nullable', Rule::unique('users', 'nik')->ignore($this->oldNik, 'nik')],
          'kode' => [Rule::unique('witel', 'kode_witel')->ignore($this->kode, 'kode_witel')],
          'no_telp' => 'nullable',
        ]
      );

      if ($this->addNewPic == true) {
        // Tambah data user + witel

        try {
          ModelUser::create([
            'name' => $this->picName,
            'nik' => $this->picNik,
            'no_telp' => $this->no_telp,
          ]);

          // Ambil id user terakhir
          $getLastUser = ModelUser::get()->last();
          $this->picId = $getLastUser['id'];
  
          ModelsWitel::where('id', $this->idWitel)->update([
            'nama_witel' => $this->nama,
            'kode_witel' => $this->kode,
            'regional' => $this->regional,
            'alamat_witel' => $this->alamat,
            'id_pic' => $this->picId,
          ]);

          LogWitel::create([
            'id_witel' => $this->idWitel,
            'data_log' => [
                          'aksi' => 'Edit',
                          'browser' => $_SERVER['HTTP_USER_AGENT'],
                          'edited_by' => session('name'),
                          'data_lama' =>  [
                                              'nama_witel' => $this->oldDataWitel['nama_witel'],
                                              'kode_witel' => $this->oldDataWitel['kode_witel'],
                                              'alamat_witel' => $this->oldDataWitel['alamat_witel'],
                                              'regional_witel' => $this->oldDataWitel['regional'],
                                              'id_pic' => $this->oldDataUser['id'],
                                              'nama_pic' => $this->oldDataUser['name'],
                                          ],
                          'data_baru' =>  [
                                              'nama_witel' => $this->nama,
                                              'kode_witel' => $this->kode,
                                              'alamat_witel' => $this->alamat,
                                              'regional_witel' => $this->regional,
                                              'id_pic' => $this->picId,
                                              'nama_pic' => $getLastUser['name'],
                                          ],
                            ],
          ]);

        }catch (\Exception $ex) {
          return $ex;
          // return $this->addError('picNik', 'Nik Sudah terdaftar');
        }
        
      } else {
        try {
          // Ubah data witel
          ModelsWitel::where('id', $this->idWitel)->update([
            'nama_witel' => $this->nama,
            'kode_witel' => $this->kode,
            'regional' => $this->regional,
            'alamat_witel' => $this->alamat,
          ]);

        LogWitel::create([
          'id_witel' => $this->idWitel,
          'data_log' => [
                        'aksi' => 'Edit',
                        'browser' => $_SERVER['HTTP_USER_AGENT'],
                        'edited_by' => session('name'),
                        'data_lama' =>  [
                                            'nama_witel' => $this->oldDataWitel['nama_witel'],
                                            'kode_witel' => $this->oldDataWitel['kode_witel'],
                                            'alamat_witel' => $this->oldDataWitel['alamat_witel'],
                                            'regional_witel' => $this->oldDataWitel['regional'],
                                            'id_pic' => $this->oldDataUser['id'],
                                            'nama_pic' => $this->oldDataUser['name'],
                                        ],
                        'data_baru' =>  [
                                            'nama_witel' => $this->nama,
                                            'kode_witel' => $this->kode,
                                            'alamat_witel' => $this->alamat,
                                            'regional_witel' => $this->regional,
                                            'id_pic' => $this->picId,
                                            'nama_pic' => $this->picName,
                                        ],
                          ],
        ]);
            
        } catch (\Exception $ex) {
          return $this->addError('kode', 'Kode Witel Sudah ada');
        }
      }

      // Panggil fungsi Reset data
      $this->resetData();

      // Tutup Modal
      $this->isOpen = false;
      $this->addNewPic = false;

      // Panggil SweetAlert berhasil
      $this->emit('success', 'Data Witel Berhasil Ditambahkan');

    }

    public function addPic()
    {
        $this->addNewPic = true;
        $this->reset('picName', 'picNik', 'no_telp', 'picSearch');
    }

    public function choosePic($id) 
    {
      $picData = ModelUser::where('id', $id)->first();
      // dd($id);
      $this->picId = $id;
      $this->picName = $picData['name'];
      $this->picNik = $picData['nik'];
      $this->no_telp = $picData['no_telp'];
      $this->reset('picSearch');
    }

    public function delete($id)
    {
      $witelQuery = ModelsWitel::where('id', $id)->first();
      $witelQuery->delete();

      $dataUser  = ModelUser::where('id', $witelQuery['id_pic'])->first();
      LogWitel::create([
        'id_witel' => $id,
        'data_log' => [
                      'aksi' => 'Hapus',
                      'browser' => $_SERVER['HTTP_USER_AGENT'],
                      'edited_by' => session('name'),
                      'data_lama' =>  [
                                          'nama_witel' => $witelQuery['nama_witel'],
                                          'kode_witel' => $witelQuery['kode_witel'],
                                          'alamat_witel' => $witelQuery['alamat_witel'],
                                          'regional_witel' => $witelQuery['regional'],
                                          'id_pic' => $dataUser['id'],
                                          'nama_pic' => $dataUser['name'],
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
