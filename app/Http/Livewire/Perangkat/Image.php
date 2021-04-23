<?php

namespace App\Http\Livewire\Perangkat;

use App\Models\Image as ModelsImage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Image extends Component
{
    use WithPagination;
    
    public $submitType, $keyword, $kode, $imageId, $imageData;
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
    }

    public function edit($id) 
    {
        $this->submitType = 'update';
        $this->imageData = ModelsImage::where('id', $id)->first();

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
        $this->reset('kode', 'submitType', 'imageId', 'imageData');
    }
}
