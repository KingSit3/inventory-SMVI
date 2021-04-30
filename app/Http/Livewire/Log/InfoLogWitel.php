<?php

namespace App\Http\Livewire\Log;

use App\Models\LogWitel;
use App\Models\User;
use App\Models\Witel;
use Livewire\Component;
use Livewire\WithPagination;

class InfoLogWitel extends Component
{
    use WithPagination;
    public $logData, $dataPic;

    public function mount($id) 
    {
        $this->logData = Witel::where('id', $id)
                                ->withTrashed()
                                ->first();
        $this->dataPic = User::where('id', $this->logData['id_pic'])->first();
    }

    public function render()
    {
        $data = [
            'logWitel' => LogWitel::where('id_witel', $this->logData['id'])
                                ->orderBy('created_at', 'DESC')->paginate(7),
        ];

        return view('livewire.log.info-log-witel', $data)
        ->extends('layouts.app');
    }
}
