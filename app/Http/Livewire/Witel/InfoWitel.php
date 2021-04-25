<?php

namespace App\Http\Livewire\Witel;

use App\Models\Perangkat;
use App\Models\Witel;
use Livewire\Component;
use Livewire\WithPagination;

class InfoWitel extends Component
{
    use WithPagination;
    public $witelData;
    public $keyword = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount($id) 
    {
        $this->witelData = Witel::with('users')->where('id', $id)->withTrashed()->first();
    }
    
    public function render()
    {
        $keyword = '%'.$this->keyword.'%';

        $dataPerangkat = Perangkat::with(['users', 'witel', 'TipePerangkat', 'DeliveryOrder'])
                                    ->where('id_witel', $this->witelData['id'])
                                    ->where('sn_pengganti', 'like', $keyword)
                                    ->orderBy('updated_at', 'DESC')->paginate(7);

        $data = [
            'perangkat' => $dataPerangkat,
            'totalPerangkat' => Perangkat::where('id_witel', $this->witelData['id'])->count(),
        ];


        return view('livewire.witel.info-witel', $data)
        ->extends('layouts.app');
    }
}
