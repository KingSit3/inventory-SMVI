<?php

namespace App\Http\Livewire\Log;

use App\Models\LogWitel as ModelsLogWitel;
use Livewire\Component;
use Livewire\WithPagination;

class LogWitel extends Component
{
    use WithPagination;
    public $keyword = '';

    public function render()
    {
        $keyword = '%'.$this->keyword.'%';

            $data = [
                'logDo' => ModelsLogWitel::whereHas('Witel', function($query) use ($keyword){
                    // Jalankan query search seperti biasa
                    $query->where('nama_witel', 'like', $keyword);
                })
                ->orderBy('created_at', 'DESC')
                ->paginate(10),
            ];

            return view('livewire.log.log-witel', $data)
            ->extends('layouts.app');
    }
}
