<?php

namespace App\Http\Livewire\Perangkat;

use App\Models\ModelGelombang;
use Livewire\Component;
use Livewire\WithPagination;

class Gelombang extends Component
{
    use WithPagination;

    public function render()
    {
        $data = [
            'gelombang' => ModelGelombang::paginate(10),
        ];

        return view('livewire.perangkat.gelombang', $data)
        ->extends('layouts.app');
    }

    public function tambah()
    {
        $gelombang = ModelGelombang::orderBy('created_at', 'DESC')->first();

        ModelGelombang::create([
            'nama_gelombang' => $gelombang['nama_gelombang'] + 1,
        ]);
    }
}
