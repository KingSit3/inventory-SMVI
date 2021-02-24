<?php

namespace App\Http\Livewire\Perangkat;

use App\Models\Image;
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
    }
}
