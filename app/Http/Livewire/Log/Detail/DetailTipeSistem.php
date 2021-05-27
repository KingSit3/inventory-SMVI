<?php

namespace App\Http\Livewire\Log\Detail;

use App\Models\ModelLogTipeSistem;
use Livewire\Component;

class DetailTipeSistem extends Component
{
    public $dataLog;

    protected $listeners = ['detailTipeSistem' => 'detailLog'];

    public function render()
    {
        return view('livewire.log.detail.detail-tipe-sistem')
        ->extends('layouts.app');
    }

    public function detailLog($id) 
    {  
        $this->dataLog = ModelLogTipeSistem::with('tipesistem')->where('id', $id)->first();
    }

    public function resetData() 
    {
      $this->reset();
    }
}
