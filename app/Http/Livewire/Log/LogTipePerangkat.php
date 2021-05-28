<?php

namespace App\Http\Livewire\Log;

use App\Models\ModelLogTipePerangkat;
use Livewire\Component;
use Livewire\WithPagination;

class LogTipePerangkat extends Component
{
    use WithPagination;
    public $keyword = '';

    public function render()
    {
        $keyword = '%'.$this->keyword.'%';

        $data = [
                    'logTipe' => ModelLogTipePerangkat::whereHas('TipePerangkat', function($query) use ($keyword){
                                // Jalankan query search seperti biasa
                                $query->where('kode_perangkat', 'like', $keyword);
                                })
                                ->orderBy('created_at', 'DESC')
                                ->paginate(10),
                ];

        return view('livewire.log.log-tipe-perangkat', $data)
        ->extends('layouts.app');
    }
}
