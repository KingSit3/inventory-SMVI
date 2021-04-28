<?php

namespace App\Http\Livewire\Perangkat;

use App\Models\Image as ModelsImage;
use App\Models\LogImage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Image extends Component
{
    use WithPagination;
    
    public $submitType, $keyword, $kode, $imageId, $imageData, $oldImageData;
    public $isOpen = false;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $keyword = '%'.$this->keyword.'%';

        $data = [
            'images' => ModelsImage::where('kode_image', 'like', $keyword)
            ->paginate(10),
        ];
        
        return view('livewire.perangkat.image', $data)
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
                'kode' => 'unique:App\Models\Image,kode_image',
            ]
        );

        // Save data
        ModelsImage::create([
            'kode_image' => $this->kode,
        ]);

        $idImage = ModelsImage::latest()->first();
        LogImage::create([
            'id_image' => $idImage['id'],
            'data_log' =>   [
                                'aksi' => 'Tambah',
                                'browser' => $_SERVER['HTTP_USER_AGENT'],
                                'edited_by' => session('name'),
                                'data_lama' => [],
                                'data_baru' => [
                                    'kode_image' => $this->kode,
                                    ],
                            ],
        ]);
        
        // Panggil fungsi Reset data
        $this->resetData();

        // Tutup Modal
        $this->isOpen = false;

        // Panggil SweetAlert berhasil
        $this->emit('success', 'Image Berhasil Ditambahkan');
    }

    public function delete($id)
    {
        ModelsImage::where(['id' => $id])->delete();

        // Cari kode image yang dihapus
        $kodeImage = ModelsImage::where(['id' => $id])->onlyTrashed()->first();
        LogImage::create([
            'id_image' => $id,
            'data_log' =>   [
                                'aksi' => 'Hapus',
                                'browser' => $_SERVER['HTTP_USER_AGENT'],
                                'edited_by' => session('name'),
                                'data_lama' =>  [
                                                    'kode_image' => $kodeImage['kode_image'],
                                                ],
                                'data_baru' =>  [],
                            ],
        ]);
    }

    public function edit($id) 
    {
        $this->submitType = 'update';
        $this->imageData = ModelsImage::where('id', $id)->first();
        $this->oldImageData = ModelsImage::where('id', $id)->first();

        // Masukkan value
        $this->imageId = $id;
        $this->kode = $this->imageData['kode_image'];
    }

    public function update()
    {
        $this->validate(
            [
                'kode' => [Rule::unique('image', 'kode_image')->ignore($this->kode, 'kode_image')],
            ]
        );


        // Pakai fitur Try Catch Untuk mengatasi eror unique
        try {
            ModelsImage::where('id', $this->imageId)->update([
                'kode_image' => $this->kode,
            ]);

            LogImage::create([
                'id_image' => $this->imageId,
                'data_log' =>   [
                                    'aksi' => 'Edit',
                                    'browser' => $_SERVER['HTTP_USER_AGENT'],
                                    'edited_by' => session('name'),
                                    'data_lama' =>  [
                                                        'kode_image' => $this->imageData['kode_image'],
                                                    ],
                                    'data_baru' =>  [
                                                        'kode_image' => $this->kode,
                                                    ],
                                ],
            ]);

        } catch (\Exception $ex) {
            return $this->addError('kode', 'Kode Image Sudah Ada');
        }

        // Panggil fungsi Reset data
        $this->resetData();
        // Tutup Modal
        $this->isOpen = false;
        // Panggil SweetAlert berhasil
        $this->emit('success', 'Data Image Berhasil Diubah');
    }

    public function resetData() 
    {
        // Reset Validasi
        $this->resetValidation();
        // Reset input field
        $this->reset('kode', 'submitType', 'imageId', 'imageData', 'oldImageData');
    }
}
