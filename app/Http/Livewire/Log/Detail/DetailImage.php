<?php

namespace App\Http\Livewire\Log\Detail;

use App\Models\LogImage;
use Livewire\Component;

class DetailImage extends Component
{
    public $dataLog;

    protected $listeners = ['detailLogImage' => 'detailLog'];

    public function render()
    {
        return view('livewire.log.detail.detail-image')
        ->extends('layouts.app');
    }

    public function detailLog($id) 
    {  
        $this->dataLog = LogImage::with(['image'])->where('id', $id)->first();
        // dd($this->dataLog['data_log']);
    }

    public function resetData() 
    {
      $this->reset();
    }
}
