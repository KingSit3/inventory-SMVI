<?php

namespace App\Http\Livewire\Log;

use App\Models\ModelLogPerangkat;
use App\Models\ModelPerangkat;
use Livewire\Component;
use Livewire\WithPagination;

class InfoLogPerangkat extends Component
{
    use WithPagination;
    public $logData;
    
    public function mount($id) 
    {
        $this->logData = ModelPerangkat::where('id', $id)
                                ->withTrashed()
                                ->first();
    }

    public function render()
    {
        $data = [
            'logPerangkat' => ModelLogPerangkat::with('Perangkat')->where('id_perangkat', $this->logData['id'])
                                ->orderBy('created_at', 'DESC')->paginate(10),
        ];

        return view('livewire.log.info-log-perangkat', $data)
        ->extends('layouts.app');
    }
}
