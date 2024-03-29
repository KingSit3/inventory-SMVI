<?php

namespace App\Http\Livewire\User;

use App\Models\ModelPerangkat as Perangkat;
use App\Models\ModelUser as User;
use Livewire\Component;
use Livewire\WithPagination;

class InfoUser extends Component
{
    use WithPagination;
    public $userData;
    public $keyword = '';
    public $isOpen = false;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount($id) 
    {
        $this->userData = User::where('id', $id)->withTrashed()->first();
    }

    public function render()
    {
        $keyword = '%'.$this->keyword.'%';

        $dataPerangkat = Perangkat::with(['cabang', 'TipePerangkat', 'pengiriman'])
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
