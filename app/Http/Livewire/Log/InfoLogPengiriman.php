<?php

namespace App\Http\Livewire\Log;

use App\Models\ModelPengiriman;
use App\Models\ModelLogPengiriman;
use Livewire\Component;
use Livewire\WithPagination;

class InfoLogpengiriman extends Component
{
    use WithPagination;
    public $logData;

    public function mount($id) 
    {
        $this->logData = ModelPengiriman::where('id', $id)
                                ->withTrashed()
                                ->first();
    }
    
    public function render()
    {
        $data = [
            'logPengiriman' => ModelLogPengiriman::with('pengiriman')->where('id_pengiriman', $this->logData['id'])
                                ->orderBy('created_at', 'DESC')->paginate(10),
        ];


        return view('livewire.log.info-log-pengiriman', $data)
        ->extends('layouts.app');
    }
}
