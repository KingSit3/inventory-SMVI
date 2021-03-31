<?php

namespace App\Http\Livewire\Witel;

use App\Models\User as ModelUser;
use App\Models\Witel as ModelsWitel;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Witel extends Component
{
    use WithPagination;
    public  $idWitel, $dbWitel, $submitType, $nama, 
            $kode, $regional, $alamat, $keyword;
    public $picNik, $picId, $no_telp, $picName, $picSearch, $dbUser;
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
          'picNik' => ['numeric', 'nullable', Rule::unique('users', 'nik')->ignore($this->picNik, 'nik')],
          'kode' => 'unique:App\Models\Witel,kode_witel',
          'no_telp' => 'nullable',
        ],
        // Message
        [
          'regional.numeric' => 'Regional harus Angka',
          'picNik.unique' => 'Nik sudah ada',
          'kode.unique' => 'Kode Witel sudah ada',
          'picNik.numeric' => 'Harus berupa nomor',
          'no_telp.numeric' => 'Harus berupa nomor',
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
          $getLastUser = ModelUser::get()->last();
          $this->picId = $getLastUser['id'];
  
          ModelsWitel::create([
            'nama_witel' => $this->nama,
            'kode_witel' => $this->kode,
            'regional' => $this->regional,
            'alamat_witel' => $this->alamat,
            'id_pic' => $this->picId,
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
      $this->dbUser = ModelUser::where('id', $this->dbWitel['id_pic'])->first();

      $this->idWitel = $id;
      // Value input
      $this->nama = $this->dbWitel['nama_witel'];
      $this->kode = $this->dbWitel['kode_witel'];
      $this->regional = $this->dbWitel['regional'];
      $this->alamat = $this->dbWitel['alamat_witel'];

      $this->picNik = $this->dbUser['nik'];
      $this->picName = $this->dbUser['name'];
      $this->no_telp = $this->dbUser['no_telp'];
    }

    public function update() 
    {
      $this->validate(
        // Rules
        [
          'regional' => 'nullable|numeric',
          'picNik' => ['numeric', 'nullable', Rule::unique('users', 'nik')->ignore($this->picNik, 'nik')],
          'picNik' => ['numeric', 'nullable', Rule::unique('users', 'nik')->ignore($this->picNik, 'nik')],
          'kode' => [Rule::unique('witel', 'kode_witel')->ignore($this->kode, 'kode_witel')],
          'no_telp' => 'numeric|nullable',
        ],
        // Message
        [
          'regional.numeric' => 'Regional harus Angka',
          'picNik.unique' => 'Nik sudah ada',
          'kode.unique' => 'Kode Witel sudah ada',
          'picNik.numeric' => 'Harus berupa nomor',
          'no_telp.numeric' => 'Harus berupa nomor',
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
          $getLastUser = ModelUser::get()->last();
          $this->picId = $getLastUser['id'];
  
          ModelsWitel::where('id', $this->idWitel)->update([
            'nama_witel' => $this->nama,
            'kode_witel' => $this->kode,
            'regional' => $this->regional,
            'alamat_witel' => $this->alamat,
            'id_pic' => $this->picId,
          ]);

        }catch (\Exception $ex) {
          return $this->addError('picNik', 'Nik Sudah terdaftar');
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
      ModelsWitel::find($id)->delete();
    }

    public function resetData()
    {
        // Reset Validasi
        $this->resetValidation();
        // Reset input field
        $this->reset('idWitel', 'dbWitel', 'submitType', 
        'nama', 'kode', 'regional', 'alamat', 'picId', 
        'picName', 'picNik', 'no_telp', 'dbUser', 'addNewPic');
    }
}
