<?php

namespace App\Http\Livewire\Log\Detail;

use App\Models\LogDeliveryOrder;
use Livewire\Component;

class DetailDeliveryOrder extends Component
{
    public $dataLog;
    protected $listeners = ['detailLogDeliveryOrder' => 'detailLog'];

    public function render()
    {
        return view('livewire.log.detail.detail-delivery-order')
        ->extends('layouts.app');
    }

    public function detailLog($id) 
    {
      $this->dataLog = LogDeliveryOrder::with('deliveryOrder')
                            ->where('id', $id)
                            ->first();
        // dd($this->dataLog);
    }

    public function resetData() 
    {
      $this->reset();
    }
}
