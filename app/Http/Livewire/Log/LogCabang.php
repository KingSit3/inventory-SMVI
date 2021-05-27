<?php

namespace App\Http\Livewire\Log;

use App\Models\ModelLogCabang;
use Livewire\Component;
use Livewire\WithPagination;

class LogCabang extends Component
{
    use WithPagination;
    public $keyword = '';

    public function render()
    {
        $keyword = '%'.$this->keyword.'%';

            $data = [
                'logCabang' => ModelLogCabang::with('cabang')->whereHas('Cabang', function($query) use ($keyword){
                    // Jalankan query search seperti biasa
                    $query->where('nama_cabang', 'like', $keyword);
                })
                ->orderBy('created_at', 'DESC')
                ->paginate(10),
            ];

            return view('livewire.log.log-cabang', $data)
            ->extends('layouts.app');
    }
}
