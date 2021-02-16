<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;

class Users extends Component
{
    public function render()
    {
        $data = [
            'users' => User::paginate(3),
        ];

        return view('livewire.user.users', $data)
        ->extends('layouts.app');
    }
}
