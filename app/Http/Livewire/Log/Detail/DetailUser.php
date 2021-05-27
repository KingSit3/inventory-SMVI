<?php

namespace App\Http\Livewire\Log\Detail;

use App\Models\ModelLogUser as LogUser;
use Livewire\Component;

class DetailUser extends Component
{
    public $dataLog;
    protected $listeners = ['detailuser' => 'detailLog'];

    public function render()
    {
        return view('livewire.log.detail.detail-user');
    }

    public function detailLog($id) 
    {
      $this->dataLog = LogUser::with('user')
                            ->where('id', $id)
                            ->first();
    }

    public function resetData() 
    {
      $this->reset();
    }
}
