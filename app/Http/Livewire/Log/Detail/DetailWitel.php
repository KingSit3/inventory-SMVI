<?php

namespace App\Http\Livewire\Log\Detail;

use App\Models\LogWitel;
use Livewire\Component;

class DetailWitel extends Component
{
    public $dataLog;
    protected $listeners = ['detailWitel' => 'detailLog'];

    public function render()
    {
        return view('livewire.log.detail.detail-witel');
    }

    public function detailLog($id) 
    {
      $this->dataLog = LogWitel::with('witel')
                            ->where('id', $id)
                            ->first();
        // dd($this->dataLog);
    }

    public function resetData() 
    {
      $this->reset();
    }
}
