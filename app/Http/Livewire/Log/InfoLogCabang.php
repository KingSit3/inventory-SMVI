<?php

namespace App\Http\Livewire\Log;

use App\Models\ModelLogCabang as LogCabang;
use App\Models\ModelUser as User;
use App\Models\ModelCabang;
use Livewire\Component;
use Livewire\WithPagination;

class InfoLogCabang extends Component
{
    use WithPagination;
    public $logData, $dataPic;

    public function mount($id) 
    {
        $this->logData = ModelCabang::with('users')->where('id', $id)
                                ->withTrashed()
                                ->first();
    }

    public function render()
    {
        $data = [
            'logCabang' => LogCabang::with('cabang')->where('id_cabang', $this->logData['id'])
                                ->orderBy('created_at', 'DESC')->paginate(7),
        ];

        return view('livewire.log.info-log-cabang', $data)
        ->extends('layouts.app');
    }
}
