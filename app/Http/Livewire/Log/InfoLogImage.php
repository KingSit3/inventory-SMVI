<?php

namespace App\Http\Livewire\Log;

use App\Models\Image;
use App\Models\LogImage;
use Livewire\Component;
use Livewire\WithPagination;

class InfoLogImage extends Component
{
    use WithPagination;
    public $logData;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount($id) 
    {
        $this->logData = Image::where('id', $id)->withTrashed()->first();
    }

    public function render()
    {
        
        $data = [
            'logImage' => LogImage::where('id_image', $this->logData['id'])
                                ->orderBy('created_at', 'DESC')->paginate(10),
        ];
        // dd($data['logImage']);

        return view('livewire.log.info-log-image', $data)
        ->extends('layouts.app');
    }
}
