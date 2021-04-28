<?php

namespace App\Http\Livewire\Perangkat;

use App\Models\SP as ModelsSP;
use Livewire\Component;
use Livewire\WithPagination;

class SP extends Component
{
    use WithPagination;

    public function render()
    {
        $data = [
            'SP' => ModelsSP::paginate(10),
        ];

        return view('livewire.perangkat.s-p', $data)
        ->extends('layouts.app');
    }

    public function tambah()
    {
        $SP = ModelsSP::orderBy('created_at', 'DESC')->first();

        ModelsSP::create([
            'nama_sp' => $SP['nama_sp'] + 1,
        ]);
    }
}
