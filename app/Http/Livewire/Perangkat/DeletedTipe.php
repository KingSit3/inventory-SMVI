<?php

namespace App\Http\Livewire\Perangkat;

use App\Models\tipePerangkat;
use Livewire\Component;
use Livewire\WithPagination;

class DeletedTipe extends Component
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
            'tipe_perangkat' => tipePerangkat::onlyTrashed()
                                ->where('kode_perangkat', 'like', $keyword)
                                // ->orWhere('nama_perangkat', 'like', $keyword)
                                ->orderBy('deleted_at', 'DESC')
                                ->paginate(10),
        ];

        return view('livewire.perangkat.deleted-tipe', $data)
        ->extends('layouts.app');
    }

    public function restore($id) 
    {
        tipePerangkat::where('id', $id)->restore(); 
    }
}
