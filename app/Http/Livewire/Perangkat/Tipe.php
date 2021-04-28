<?php

namespace App\Http\Livewire\Perangkat;

use App\Models\LogTipePerangkat;
use App\Models\tipePerangkat;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Tipe extends Component
{
    use WithPagination;
    public $idPerangkat, $dbPerangkat, $oldDataTipe, $kode, $nama, $tipe, $submitType, $keyword;
    public $isOpen = false;

     // Method dari Livewire untuk reset filter saat pagination
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $keyword = '%'.$this->keyword.'%';

        $data = [
            'tipe_perangkat' => tipePerangkat::where('nama_perangkat', 'like', $keyword)
                                        ->orWhere('kode_perangkat', 'like', $keyword)
                                        ->paginate(10),
        ];

        return view('livewire.perangkat.tipe', $data)
        ->extends('layouts.app');
    }

    public function add() 
    {
      $this->submitType = 'tambah';
    }

    public function tambah() 
    {
        // Validasi
        $this->validate(
            // Rules
            [
                'kode' => 'unique:App\Models\tipePerangkat,kode_perangkat',
            ],
        );

        // $newNik = ;

        // Save data
        tipePerangkat::create([
            'nama_perangkat' => $this->nama,
            'tipe_perangkat' => $this->tipe,
            'kode_perangkat' => $this->kode,
        ]);

        $idTipe = tipePerangkat::latest()->first();
        LogTipePerangkat::create([
            'id_tipe' => $idTipe['id'],
            'data_log' =>   [
                                'aksi' => 'Tambah',
                                'browser' => $_SERVER['HTTP_USER_AGENT'],
                                'edited_by' => session('name'),
                                'data_lama' =>  [],
                                'data_baru' =>  [
                                                'nama_tipe' => $this->nama,
                                                'tipe_perangkat' => $this->tipe,
                                                'kode_tipe' => $this->kode,
                                                ],
                            ],
        ]);
        
        // Panggil fungsi Reset data
        $this->resetData();

        // Tutup Modal
        $this->isOpen = false;

        // Panggil SweetAlert berhasil
        $this->emit('success', 'Tipe Perangkat Berhasil Ditambahkan');
    }

    public function delete($id) 
    {
        $tipeQuery = tipePerangkat::where('id', $id)->first();
        $tipeQuery->delete();

        LogTipePerangkat::create([
            'id_tipe' => $id,
            'data_log' =>   [
                                'aksi' => 'Hapus',
                                'browser' => $_SERVER['HTTP_USER_AGENT'],
                                'edited_by' => session('name'),
                                'data_lama' =>  [
                                                    'nama_tipe' => $tipeQuery['nama_perangkat'],
                                                    'tipe_perangkat' => $tipeQuery['tipe_perangkat'],
                                                    'kode_tipe' => $tipeQuery['kode_perangkat'],
                                                ],
                                'data_baru' =>  [],
                            ],
        ]);
    }

    public function edit($id) 
    {
      $this->submitType = 'update';
      $this->dbPerangkat = tipePerangkat::where('id', $id)->first();
      $this->oldDataTipe = tipePerangkat::where('id', $id)->first();

      $this->idPerangkat = $id;
      $this->nama = $this->dbPerangkat['nama_perangkat'];
      $this->tipe = $this->dbPerangkat['tipe_perangkat'];
      $this->kode = $this->dbPerangkat['kode_perangkat'];
    }

    public function update() 
    {
        $this->validate(
            // Rules
            [
                'kode' => [Rule::unique('tipe_perangkat', 'kode_perangkat')->ignore($this->kode, 'kode_perangkat')],
            ]
        );

        // Pakai fitur Try Catch Untuk mengatasi eror unique
        try {
            tipePerangkat::where('id', $this->idPerangkat)->update([
                'nama_perangkat' => $this->nama,
                'tipe_perangkat' => $this->tipe,
                'kode_perangkat' => $this->kode,
                ]);

            LogTipePerangkat::create([
                'id_tipe' => $this->idPerangkat,
                'data_log' =>   [
                                    'aksi' => 'Edit',
                                    'browser' => $_SERVER['HTTP_USER_AGENT'],
                                    'edited_by' => session('name'),
                                    'data_lama' =>  [
                                                        'nama_tipe' => $this->oldDataTipe['nama_perangkat'],
                                                        'tipe_perangkat' => $this->oldDataTipe['tipe_perangkat'],
                                                        'kode_tipe' => $this->oldDataTipe['kode_perangkat'],
                                                    ],
                                    'data_baru' =>  [
                                                        'nama_tipe' => $this->nama,
                                                        'tipe_perangkat' => $this->tipe,
                                                        'kode_tipe' => $this->kode,
                                                    ],
                                ],
            ]);
        } catch (\Exception $ex) {
            return $this->addError('kode', 'Kode Perangkat Sudah Ada');
        }

        // Panggil fungsi Reset data
        $this->resetData();

        // Tutup Modal
        $this->isOpen = false;

        // Panggil SweetAlert berhasil
        $this->emit('success', 'Tipe Perangkat Berhasil Diubah');

    }

    public function resetData() 
    {
        // Reset Validasi
        $this->resetValidation();
        // Reset input field
        $this->reset('nama', 'tipe', 'kode', 'submitType', 'idPerangkat', 'oldDataTipe', 'dbPerangkat');
    }
}
