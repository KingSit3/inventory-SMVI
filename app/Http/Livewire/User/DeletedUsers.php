<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class DeletedUsers extends Component
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
            'users' => User::onlyTrashed()
                                ->where('name', 'like', $keyword)
                                // ->orWhere('nik', 'like', $keyword)
                                ->orderBy('deleted_at', 'DESC')
                                ->paginate(10),
        ];

        return view('livewire.user.deleted-users', $data)
        ->extends('layouts.app');
    }

    public function restore($id) 
    {
        User::where('id', $id)->restore();
    }
}
