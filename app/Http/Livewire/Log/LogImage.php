<?php

namespace App\Http\Livewire\Log;

use App\Models\LogImage as ModelsLogImage;
use Livewire\Component;

class LogImage extends Component
{

    public function render()
    {
        // Kalau mau pake GroupBy, ubah setting database di folder config menjadi 'strict' => false,
        $data = [
            'logImage' => ModelsLogImage::with('image')->orderBy('created_at', 'DESC')->paginate(10),
        ];

        return view('livewire.log.log-image', $data)
        ->extends('layouts.app');
    }
}
