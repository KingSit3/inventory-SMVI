<?php

namespace App\Http\Livewire\Log;

use App\Models\LogUser as ModelsLogUser;
use Livewire\Component;
use Livewire\WithPagination;

class LogUser extends Component
{
    use WithPagination;
    public $keyword = '';
    
    public function render()
    {
        $keyword = '%'.$this->keyword.'%';

        $data = [
            'logUser' => ModelsLogUser::whereHas('User', function($query) use ($keyword){
                // Jalankan query search seperti biasa
                $query->where('name', 'like', $keyword);
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(10),
        ];
        return view('livewire.log.log-user', $data)
        ->extends('layouts.app');
    }
}
