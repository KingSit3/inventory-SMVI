<?php

namespace App\Http\Livewire\Log;

use App\Models\LogPerangkat;
use App\Models\Perangkat;
use App\Models\tipePerangkat;
use Livewire\Component;
use Livewire\WithPagination;

class InfoLogPerangkat extends Component
{
    use WithPagination;
    public $logData;
    
    public function mount($id) 
    {
        $this->logData = Perangkat::where('id', $id)
                                ->withTrashed()
                                ->first();
    }

    public function render()
    {
        $data = [
            'logPerangkat' => LogPerangkat::where('id_perangkat', $this->logData['id'])
                                ->orderBy('created_at', 'DESC')->paginate(10),
        ];

        return view('livewire.log.info-log-perangkat', $data)
        ->extends('layouts.app');
    }
}
