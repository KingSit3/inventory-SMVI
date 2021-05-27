<?php

namespace App\Http\Livewire\Log;

use App\Models\ModelTipeSistem;
use App\Models\ModelLogTipeSistem;
use Livewire\Component;
use Livewire\WithPagination;

class InfoLogTipeSistem extends Component
{
    use WithPagination;
    public $logData;

    public function mount($id) 
    {
        $this->logData = ModelTipeSistem::where('id', $id)->withTrashed()->first();
    }

    public function render()
    {
        
        $data = [
            'logTipeSistem' => ModelLogTipeSistem::with('tipesistem')->where('id_sistem', $this->logData['id'])
                                ->orderBy('created_at', 'DESC')->paginate(10),
        ];

        return view('livewire.log.info-log-tipe-sistem', $data)
        ->extends('layouts.app');
    }
}
