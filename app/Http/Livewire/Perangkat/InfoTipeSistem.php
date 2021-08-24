<?php

namespace App\Http\Livewire\Perangkat;

use App\Models\ModelTipeSistem;
use App\Models\ModelPerangkat as perangkat;
use Livewire\Component;
use Livewire\WithPagination;

class InfoTipeSistem extends Component
{
    use WithPagination;
    public $tipeSistem;
    public $keyword = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount($id) 
    {   
        $this->tipeSistem = ModelTipeSistem::where('id', $id)->withTrashed()->first();
    }

    public function render()
    {
        $keyword = '%'.$this->keyword.'%';

        $dataPerangkat = Perangkat::with(['users', 'tipesistem', 'TipePerangkat', 'pengiriman'])
                                    ->where('id_sistem', $this->tipeSistem['id'])
                                    ->where('sn_pengganti', 'like', $keyword)
                                    ->orderBy('updated_at', 'DESC')->paginate(10);

        $data = [
            'perangkat' => $dataPerangkat,
            'totalPerangkat' => Perangkat::where('id_sistem', $this->tipeSistem['id'])->count(),
        ];

        return view('livewire.perangkat.info-tipe-sistem', $data)
        ->extends('layouts.app');
    }
}
