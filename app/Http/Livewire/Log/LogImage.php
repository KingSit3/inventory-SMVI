<?php

namespace App\Http\Livewire\Log;

use App\Models\LogImage as ModelsLogImage;
use Livewire\Component;
use Livewire\WithPagination;

class LogImage extends Component
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
            'logImage' => ModelsLogImage::whereHas('image', function($query) use ($keyword){
                                            // Jalankan query search seperti biasa
                                            $query->where('kode_image', 'like', $keyword);
                                            })
                                            ->orderBy('created_at', 'DESC')
                                            ->paginate(10),
        ];

        return view('livewire.log.log-image', $data)
        ->extends('layouts.app');
    }
}
