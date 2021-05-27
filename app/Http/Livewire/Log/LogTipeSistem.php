<?php

namespace App\Http\Livewire\Log;

use App\Models\ModelLogTipeSistem;
use Livewire\Component;
use Livewire\WithPagination;

class LogTipeSistem extends Component
{
    use WithPagination;
    public $keyword = '';

    public function render()
    {
        $keyword = '%'.$this->keyword.'%';

        // Kalau mau pake GroupBy, ubah setting database di folder config menjadi 'strict' => false,
        $data = [
            // WhereHas(nama Tabel Relasi, callback($variabelbebas))
            // Use ($variabel yang ingin dipakai di callback) itu agar bisa pakai nama variabel luar untuk di fungsi 
            'logTipeSistem' => ModelLogTipeSistem::with('tipesistem')
                                            ->whereHas('TipeSistem', function($query) use ($keyword){
                                                // Jalankan query search seperti biasa
                                                $query->where('kode_sistem', 'like', $keyword);
                                            })
                                            ->orderBy('created_at', 'DESC')
                                            ->paginate(10),
        ];

        return view('livewire.log.log-tipe-sistem', $data)
        ->extends('layouts.app');
    }
}
