<?php

namespace App\Http\Livewire\Log;

use App\Models\ModelLogpengiriman;
use Livewire\Component;
use Livewire\WithPagination;

class LogPengiriman extends Component
{
    use WithPagination;
    public $keyword = '';

    public function render()
    {
        $keyword = '%'.$this->keyword.'%';

        $data = [
            'logPengiriman' => ModelLogpengiriman::whereHas('pengiriman', function($query) use ($keyword){
                                                    // Jalankan query search seperti biasa
                                                    $query->where('no_pengiriman', 'like', $keyword);
                                                })
                                                ->orderBy('created_at', 'DESC')
                                                ->paginate(10),
        ];
        return view('livewire.log.log-pengiriman', $data)
        ->extends('layouts.app');
    }
}
