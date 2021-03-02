<?php

namespace App\Http\Livewire\Witel;

use App\Models\Witel;
use Livewire\Component;
use Livewire\WithPagination;

class DeletedWitel extends Component
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
            'witel' => Witel::onlyTrashed()
                        ->where('nama_witel', 'like', $keyword)
                        ->orderBy('deleted_at', 'DESC')
                        ->paginate(10),
        ];

        return view('livewire.witel.deleted-witel', $data)
        ->extends('layouts.app');
    }

    public function restore($id) 
    {
        Witel::where('id', $id)->restore();
    }
}
