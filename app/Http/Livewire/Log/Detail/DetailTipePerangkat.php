<?php

namespace App\Http\Livewire\Log\Detail;

use App\Models\LogTipePerangkat;
use Livewire\Component;

class DetailTipePerangkat extends Component
{
    public $dataLog;
    protected $listeners = ['detailLogTipePerangkat' => 'detailLog'];

    public function render()
    {
        return view('livewire.log.detail.detail-tipe-perangkat')
        ->extends('layouts.app');
    }

    public function detailLog($id) 
    {
        $this->dataLog = LogTipePerangkat::with(['tipePerangkat'])->where('id', $id)->first();
        // dd($this->dataLog['data_log']);
    }

    public function resetData() 
    {
      $this->reset();
    }
}
