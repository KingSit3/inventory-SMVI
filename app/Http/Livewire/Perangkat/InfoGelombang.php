<?php

namespace App\Http\Livewire\Perangkat;

use App\Models\ModelPerangkat as Perangkat;
use App\Models\ModelGelombang;
use Livewire\Component;
use Livewire\WithPagination;

class Infogelombang extends Component
{
    use WithPagination;
    public $gelombang;
    public $keyword = '';
    public $isOpen = false;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount($nama) 
    {
        $this->gelombang = $nama;
    }

    public function render()
    {
        $keyword = '%'.$this->keyword.'%';

        $dataPerangkat = Perangkat::with(['users', 'cabang', 'TipePerangkat', 'pengiriman'])
                                    ->where('gelombang', $this->gelombang)
                                    ->where('sn_pengganti', 'like', $keyword)
                                    ->orderBy('updated_at', 'DESC')->paginate(10);

        $data = [
            'perangkat' => $dataPerangkat,
            'totalPerangkat' => Perangkat::where('gelombang', $this->gelombang)->count(),
        ];

        return view('livewire.perangkat.info-gelombang', $data)
        ->extends('layouts.app');
    }
}
