<?php

namespace App\Http\Livewire\Log\Detail;

use App\Models\LogPerangkat;
use Livewire\Component;

class DetailPerangkat extends Component
{
    public $dataLog;
    protected $listeners = ['detailPerangkat' => 'detailLog'];

    public function render()
    {
        return view('livewire.log.detail.detail-perangkat');
    }

    public function detailLog($id) 
    {
      $this->dataLog = LogPerangkat::with('Perangkat')
                            ->where('id', $id)
                            ->first();
        // dd($this->dataLog);
    }

    public function resetData() 
    {
      $this->reset();
    }
}
