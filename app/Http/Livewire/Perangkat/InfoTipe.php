<?php

namespace App\Http\Livewire\Perangkat;

use App\Models\Perangkat;
use App\Models\tipePerangkat;
use Livewire\Component;
use Livewire\WithPagination;

class InfoTipe extends Component
{
    use WithPagination;
    public $tipeData;
    public $keyword = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount($id) 
    {
        $this->tipeData = tipePerangkat::where('id', $id)->withTrashed()->first();
    }
    
    public function render()
    {
        $keyword = '%'.$this->keyword.'%';

        $dataPerangkat = Perangkat::with(['users', 'witel', 'TipePerangkat', 'DeliveryOrder'])
                                    ->where('id_tipe', $this->tipeData['id'])
                                    ->where('sn_pengganti', 'like', $keyword)
                                    ->orderBy('updated_at', 'DESC')->paginate(10);

        $data = [
            'perangkat' => $dataPerangkat,
            'totalPerangkat' => Perangkat::where('id_tipe', $this->tipeData['id'])->count(),
        ];

        return view('livewire.perangkat.info-tipe', $data)
        ->extends('layouts.app');
    }
}
