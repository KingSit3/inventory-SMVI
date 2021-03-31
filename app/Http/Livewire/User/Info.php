<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;

class Info extends Component
{
    public $userId;

    // ambil data dari route parameter
    public function mount($id) 
    {
        $this->userId = User::where('id', $id)->first();
    }

    public function render()
    {
        
        return view('livewire.user.info')
        ->extends('layouts.app');
    }
}
