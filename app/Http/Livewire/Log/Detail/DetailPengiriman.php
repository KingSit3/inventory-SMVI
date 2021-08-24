<?php

namespace App\Http\Livewire\Log\Detail;

use App\Models\ModelLogPengiriman;
use Livewire\Component;

class DetailPengiriman extends Component
{
    public $dataLog;
    protected $listeners = ['detailLogPengiriman' => 'detailLog'];

    public function render()
    {
        return view('livewire.log.detail.detail-pengiriman')
        ->extends('layouts.app');
    }

    public function detailLog($id) 
    {
      $this->dataLog = ModelLogPengiriman::with('pengiriman')
                            ->where('id', $id)
                            ->first();
    }

    public function resetData() 
    {
      $this->reset();
    }
}
