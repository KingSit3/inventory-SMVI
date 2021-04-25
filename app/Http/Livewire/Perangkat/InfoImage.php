<?php

namespace App\Http\Livewire\Perangkat;

use App\Models\Image;
use App\Models\Perangkat;
use Livewire\Component;
use Livewire\WithPagination;

class InfoImage extends Component
{
    use WithPagination;
    public $imageData;
    public $keyword = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount($id) 
    {
        $this->imageData = Image::where('id', $id)->first();
    }

    public function render()
    {
        $keyword = '%'.$this->keyword.'%';

        $dataPerangkat = Perangkat::with(['users', 'witel', 'TipePerangkat', 'DeliveryOrder'])
                                    ->where('id_image', $this->imageData['id'])
                                    ->where('sn_pengganti', 'like', $keyword)
                                    ->orderBy('updated_at', 'DESC')->paginate(10);

        $data = [
            'perangkat' => $dataPerangkat,
            'totalPerangkat' => Perangkat::where('id_image', $this->imageData['id'])->count(),
        ];

        return view('livewire.perangkat.info-image', $data)
        ->extends('layouts.app');
    }
}
