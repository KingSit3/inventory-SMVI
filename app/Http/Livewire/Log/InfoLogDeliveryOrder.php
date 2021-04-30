<?php

namespace App\Http\Livewire\Log;

use App\Models\DoModel;
use App\Models\LogDeliveryOrder;
use Livewire\Component;
use Livewire\WithPagination;

class InfoLogDeliveryOrder extends Component
{
    use WithPagination;
    public $logData;

    public function mount($id) 
    {
        $this->logData = DoModel::where('id', $id)
                                ->withTrashed()
                                ->first();
    }
    
    public function render()
    {
        $data = [
            'logDo' => LogDeliveryOrder::where('id_do', $this->logData['id'])
                                ->orderBy('created_at', 'DESC')->paginate(10),
        ];

        return view('livewire.log.info-log-delivery-order', $data)
        ->extends('layouts.app');
    }
}
