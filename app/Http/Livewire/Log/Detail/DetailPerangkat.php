<?php

namespace App\Http\Livewire\Log\Detail;

use App\Models\ModelLogPerangkat;
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
      $this->dataLog = ModelLogPerangkat::with('Perangkat')
                            ->where('id', $id)
                            ->first();
    }

    public function resetData() 
    {
      $this->reset();
    }
}
