<?php

namespace App\Http\Livewire\Log;

use App\Models\LogDeliveryOrder as ModelsLogDeliveryOrder;
use Livewire\Component;
use Livewire\WithPagination;

class LogDeliveryOrder extends Component
{
    use WithPagination;
    public $keyword = '';

    public function render()
    {
        $keyword = '%'.$this->keyword.'%';

        $data = [
            'logDo' => ModelsLogDeliveryOrder::whereHas('deliveryOrder', function($query) use ($keyword){
                                                    // Jalankan query search seperti biasa
                                                    $query->where('no_do', 'like', $keyword);
                                                })
                                                ->orderBy('created_at', 'DESC')
                                                ->paginate(10),
        ];
        return view('livewire.log.log-delivery-order', $data)
        ->extends('layouts.app');
    }
}
