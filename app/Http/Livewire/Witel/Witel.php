<?php

namespace App\Http\Livewire\Witel;

use App\Models\User as ModelUser;
use App\Models\Witel as ModelsWitel;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Witel extends Component
{
    public  $idWitel, $dbWitel, $submitType, $nama, 
            $kode, $regional, $alamat;
    public $picNik, $picId, $no_telp, $picName, $picSearch;
    public $isOpen, $addNewPic = false;

    public function render()
    {
      $picQuery = '';
      $picSearch = '%'.$this->picSearch.'%';
      if (strlen($this->picSearch) > 0) {
        $picQuery = ModelUser::where('name', 'like', $picSearch)->limit(5)->get();
        $this->addNewPic = false;
      } 

        $data = [
            // Joins using Relationship
            'witel' => ModelsWitel::with('Users')->paginate(10),
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
  
          ModelsWitel::create([
            'nama_witel' => $this->nama,
            'kode_witel' => $this->kode,
            'regional' => $this->regional,
            'alamat_witel' => $this->alamat,
            'id_pic' => $this->picId,
          ]);

        }catch (\Exception $ex) {
          return $this->addError('picNik', 'PIC ada di Witel lain');
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
        'nama', 'kode', 'regional', 'alamat', 'picId', 'picName', 'picNik', 'no_telp');
    }

    // Ambil data dari search pic
    // Cari data di database berdasarkan nama pic
    // ambil data dari database, lalu masukkan data tadi ke input field pic
    // jika ada data maka, hanya ambil data id pic saja, lalu simpan ke tabel witel
    // jika tidak ada data, maka ambil semua data dari input field, lalu simpan ke tabel user & witel
    // untuk ambil data ID user terakhir dd(User::all()->last());
}
