<?php

namespace App\Http\Livewire\Perangkat;

use App\Models\Perangkat;
use App\Models\SP;
use Livewire\Component;
use Livewire\WithPagination;

class InfoSp extends Component
{
    use WithPagination;
    public $spData;
    public $keyword = '';
    public $isOpen = false;

    public function mount($id) 
    {
        $this->spData = SP::where('id', $id)->first();
    }

    public function render()
    {
        $keyword = '%'.$this->keyword.'%';

        $dataPerangkat = Perangkat::with(['users', 'witel', 'TipePerangkat', 'DeliveryOrder'])
                                    ->where('sp', $this->spData['id'])
                                    ->where('sn_pengganti', 'like', $keyword)
                                    ->orderBy('updated_at', 'DESC')->paginate(10);

        $data = [
            'perangkat' => $dataPerangkat,
            'totalPerangkat' => Perangkat::where('sp', $this->spData['id'])->count(),
                            
        ];

        return view('livewire.perangkat.info-sp', $data)
        ->extends('layouts.app');
    }
}
