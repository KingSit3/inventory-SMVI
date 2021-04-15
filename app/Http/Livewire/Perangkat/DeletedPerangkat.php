<?php

namespace App\Http\Livewire\Perangkat;

use App\Models\Perangkat;
use Livewire\Component;
use Livewire\WithPagination;

class DeletedPerangkat extends Component
{
    public $keyword = '';
    use WithPagination;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $keyword = '%'.$this->keyword.'%';

        $data = [
            'perangkat' => Perangkat::with(['Users', 'Witel', 'DeliveryOrder', 'TipePerangkat'])
                        ->where('sn_pengganti', 'like', $keyword)
                        ->orderBy('deleted_at', 'DESC')
                        ->onlyTrashed()
                        ->paginate(10),
        ];

        return view('livewire.perangkat.deleted-perangkat', $data)
        ->extends('layouts.app');
    }

    public function restore($id) 
    {
        Perangkat::where('id', $id)->restore(); 
    }
}
