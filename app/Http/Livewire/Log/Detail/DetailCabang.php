<?php

namespace App\Http\Livewire\Log\Detail;

use App\Models\ModelLogCabang;
use Livewire\Component;

class DetailCabang extends Component
{
    public $dataLog;
    protected $listeners = ['detailCabang' => 'detailLog'];

    public function render()
    {
        return view('livewire.log.detail.detail-cabang')
        ;
    }

    public function detailLog($id) 
    {
      $this->dataLog = ModelLogCabang::with('cabang')
                            ->where('id', $id)
                            ->first();
    }

    public function resetData() 
    {
      $this->reset();
    }
}
