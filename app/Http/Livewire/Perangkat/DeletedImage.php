<?php

namespace App\Http\Livewire\Perangkat;

use App\Models\Image;
use App\Models\LogImage;
use Livewire\Component;
use Livewire\WithPagination;

class DeletedImage extends Component
{
    public $keyword = '';
    use WithPagination;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $keyword = '%'.$this->keyword.'%';

        $data = [
            'image' => Image::onlyTrashed()
                                ->where('kode_image', 'like', $keyword)
                                ->orderBy('deleted_at', 'DESC')
                                ->paginate(10),
        ];

        return view('livewire.perangkat.deleted-image', $data)
        ->extends('layouts.app');
    }

    public function restore($id) 
    {
        Image::where('id', $id)->restore();

        $kodeImage = Image::where(['id' => $id])->first();
        LogImage::create([
            'id_image' => $id,
            'data_log' =>   [
                                'aksi' => 'Restore',
                                'browser' => $_SERVER['HTTP_USER_AGENT'],
                                'edited_by' => session('name'),
                                'data_lama' =>  [
                                                    'kode_image' => $kodeImage['kode_image'],
                                                ],
                                'data_baru' =>  [],
                            ],
        ]);
    }
}
