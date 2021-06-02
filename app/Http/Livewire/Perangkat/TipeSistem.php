<?php

namespace App\Http\Livewire\Perangkat;

use App\Models\ModelTipeSistem;
use App\Models\ModelLogTipeSistem;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class TipeSistem extends Component
{
    use WithPagination;
    
    public $submitType, $keyword, $kode, 
    $tipeSistemId, $tipeSistemData;
    public $isOpen = false;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $keyword = '%'.$this->keyword.'%';

        $data = [
            'tipeSistem' => ModelTipeSistem::where('kode_sistem', 'like', $keyword)
            ->paginate(10),
        ];
        
        return view('livewire.perangkat.tipe-sistem', $data)
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
                'kode' => 'unique:App\Models\ModelTipeSistem,kode_sistem|max:25',
            ]
        );

        // Save data
        $saveTipeSistem = ModelTipeSistem::create([
            'kode_sistem' => $this->kode,
        ]);

        ModelLogTipeSistem::create([
            'id_sistem' => $saveTipeSistem->id,
            'data_log' =>   [
                                'aksi' => 'Tambah',
                                'browser' => $_SERVER['HTTP_USER_AGENT'],
                                'edited_by' => session('nama'),
                                'data_lama' => [],
                                'data_baru' => [
                                    'kode_sistem' => $this->kode,
                                    ],
                            ],
        ]);
        
        // Panggil fungsi Reset data
        $this->resetData();

        // Tutup Modal
        $this->isOpen = false;

        // Panggil SweetAlert berhasil
        $this->emit('success', 'tipe sistem Berhasil Ditambahkan');
    }

    public function delete($id)
    {
        $tipeQuery = ModelTipeSistem::where(['id' => $id])->first();
        
        ModelLogTipeSistem::create([
            'id_sistem' => $id,
            'data_log' =>   [
                                'aksi' => 'Hapus',
                                'browser' => $_SERVER['HTTP_USER_AGENT'],
                                'edited_by' => session('nama'),
                                'data_lama' =>  [
                                                    'kode_sistem' => $tipeQuery['kode_sistem'],
                                                ],
                                'data_baru' =>  [],
                            ],
        ]);

        $tipeQuery->delete();
    }

    public function edit($id) 
    {
        $this->submitType = 'update';
        $this->tipeSistemData = ModelTipeSistem::where('id', $id)->first();

        // Masukkan value
        $this->tipeSistemId = $id;
        $this->kode = $this->tipeSistemData['kode_sistem'];
    }

    public function update()
    {
        $this->validate(
            [
                'kode' => [Rule::unique('tipe_sistem', 'kode_sistem')->ignore($this->kode, 'kode_sistem'), 'max:25'],
            ]
        );

        // Pakai fitur Try Catch Untuk mengatasi eror unique
        try {
            ModelTipeSistem::where('id', $this->tipeSistemId)->update([
                'kode_sistem' => $this->kode,
            ]);

            ModelLogTipeSistem::create([
                'id_sistem' => $this->tipeSistemId,
                'data_log' =>   [
                                    'aksi' => 'Edit',
                                    'browser' => $_SERVER['HTTP_USER_AGENT'],
                                    'edited_by' => session('nama'),
                                    'data_lama' =>  [
                                                        'kode_sistem' => $this->tipeSistemData['kode_sistem'],
                                                    ],
                                    'data_baru' =>  [
                                                        'kode_sistem' => $this->kode,
                                                    ],
                                ],
            ]);

        } catch (\Exception $ex) {
            return $this->addError('kode', 'Kode Tipe Sistem Sudah Ada');
        }

        // Panggil fungsi Reset data
        $this->resetData();
        // Tutup Modal
        $this->isOpen = false;
        // Panggil SweetAlert berhasil
        $this->emit('success', 'Data Tipe Sistem Berhasil Diubah');
    }

    public function resetData() 
    {
        // Reset Validasi
        $this->resetValidation();
        // Reset input field
        $this->reset();
    }
}
