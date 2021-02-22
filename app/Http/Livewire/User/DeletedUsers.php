<?php

namespace App\Http\Livewire\User;

use Livewire\Component;

class DeletedUsers extends Component
{
    public function render()
    {

        return view('livewire.user.deleted-users')
        ->extends('layouts.app');
    }
}
