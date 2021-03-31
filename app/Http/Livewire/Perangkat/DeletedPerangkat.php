<?php

namespace App\Http\Livewire\Perangkat;

use App\Models\Perangkat;
use Livewire\Component;

class DeletedPerangkat extends Component
{
    public function render()
    {

        $data = [
            'perangkat' => Perangkat::with(['Users', 'Witel'])->onlyTrashed()->paginate(10),
        ];

        return view('livewire.perangkat.deleted-perangkat', $data)
        ->extends('layouts.app');
    }

    public function restore($id) 
    {
        Perangkat::where('id', $id)->restore(); 
    }
}
