<?php

namespace App\Http\Livewire\Perangkat;

use App\Models\Perangkat;
use Livewire\Component;

class InfoPerangkat extends Component
{
    public $dataPerangkat;

    // Dengarkan event $emit(infoPerangkat)
    protected $listeners = ['infoPerangkat' => 'detailPerangkat'];

    public function render()
    {
        return view('livewire.perangkat.info-perangkat')
        ->extends('layouts.app');
    }

    public function detailPerangkat($id) 
    {
        $this->dataPerangkat = Perangkat::with(['users', 'Witel', 'TipePerangkat', 'DeliveryOrder'])
                        ->where('id', $id)->first();
        // dd($this->dataPerangkat);
    }

    public function resetData() 
    {
      $this->reset();
    }
}
