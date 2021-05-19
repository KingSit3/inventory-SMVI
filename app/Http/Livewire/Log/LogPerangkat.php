<?php

namespace App\Http\Livewire\Log;

use App\Models\LogPerangkat as ModelsLogPerangkat;
use Livewire\Component;
use Livewire\WithPagination;

class LogPerangkat extends Component
{   
    use WithPagination;
    public $keyword = '';

    public function render()
    {
        $keyword = '%'.$this->keyword.'%';

        $data = [
            'logPerangkat' => ModelsLogPerangkat::whereHas('Perangkat', function($query) use ($keyword){
                // Jalankan query search seperti biasa
                $query->where('sn_pengganti', 'like', $keyword);
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(10),
        ];
        
        return view('livewire.log.log-perangkat', $data)
        ->extends('layouts.app');
    }
}
