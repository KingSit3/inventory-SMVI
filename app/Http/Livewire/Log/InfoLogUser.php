<?php

namespace App\Http\Livewire\Log;

use App\Models\LogUser;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class InfoLogUser extends Component
{
    use WithPagination;
    public $logData;

    public function mount($id)
    {
        $this->logData = User::where('id', $id)
                                ->withTrashed()
                                ->first();
    }

    public function render() 
    {
        $data = [
            'logUser' => LogUser::where('id_user', $this->logData['id'])
                                ->orderBy('created_at', 'DESC')->paginate(7),
        ];
        return view('livewire.log.info-log-user', $data)
        ->extends('layouts.app');
    }
}
