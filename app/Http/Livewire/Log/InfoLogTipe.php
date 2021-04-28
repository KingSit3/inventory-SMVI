<?php

namespace App\Http\Livewire\Log;

use App\Models\LogTipePerangkat;
use App\Models\tipePerangkat;
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
            'logTipe' => LogTipePerangkat::where('id_tipe', $this->logData['id'])
                                        ->orderBy('created_at', 'DESC')
                                        ->paginate(7),
                ];
        // dd($data['logImage']);

        return view('livewire.log.info-log-tipe', $data)
        ->extends('layouts.app');
    }
}
