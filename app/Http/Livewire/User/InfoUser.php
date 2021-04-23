<?php

namespace App\Http\Livewire\User;

use App\Models\Perangkat;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class InfoUser extends Component
{
    use WithPagination;
    public $userData;
    public $keyword = '';
    public $isOpen = false;

    public function mount($id) 
    {
        $this->userData = User::where('id', $id)->first();
    }

    public function render()
    {
        $keyword = '%'.$this->keyword.'%';

        $dataPerangkat = Perangkat::with(['witel', 'TipePerangkat', 'DeliveryOrder'])
                                    ->where('id_user', $this->userData['id'])
                                    ->where('sn_pengganti', 'like', $keyword)
                                    ->orderBy('updated_at', 'DESC')->paginate(7);

        $data = [
            'perangkat' => $dataPerangkat,
            'totalPerangkat' => Perangkat::where('id_user', $this->userData['id'])->count(),
        ];

        return view('livewire.user.info-user', $data)
        ->extends('layouts.app');
    }

    public function delete($id) 
    {
        Perangkat::where('id', $id)->update(['id_user' => null]);
    }
}
