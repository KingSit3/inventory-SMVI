<?php

namespace App\Http\Livewire\Log;

use App\Models\ModelLogTipePerangkat as LogTipePerangkat;
use App\Models\ModelTipePerangkat as tipePerangkat;
use Livewire\Component;
use Livewire\WithPagination;

class InfoLogTipe extends Component
{
    use WithPagination;
    public $logData;

    public function mount($id) 
    {
        $this->logData = tipePerangkat::where('id', $id)
                            ->withTrashed()
                            ->first();
    }

    public function render()
    {
        $data = [
            'logTipe' => LogTipePerangkat::with('TipePerangkat')->where('id_tipe', $this->logData['id'])
                                        ->orderBy('created_at', 'DESC')
                                        ->paginate(7),
                ];

        return view('livewire.log.info-log-tipe', $data)
        ->extends('layouts.app');
    }
}
