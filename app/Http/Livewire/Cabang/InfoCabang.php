<?php

namespace App\Http\Livewire\Cabang;

use App\Models\ModelPerangkat as Perangkat;
use App\Models\ModelCabang;
use Livewire\Component;
use Livewire\WithPagination;

class InfoCabang extends Component
{
    use WithPagination;
    public $cabangData;
    public $keyword = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount($id) 
    {
        $this->cabangData = ModelCabang::with('users')->where('id', $id)->withTrashed()->first();
    }
    
    public function render()
    {
        $keyword = '%'.$this->keyword.'%';

        $dataPerangkat = Perangkat::with(['users', 'cabang', 'TipePerangkat', 'pengiriman'])
                                    ->where('id_cabang', $this->cabangData['id'])
                                    ->where('sn_pengganti', 'like', $keyword)
                                    ->orderBy('updated_at', 'DESC')->paginate(7);

        $data = [
            'perangkat' => $dataPerangkat,
            'totalPerangkat' => Perangkat::where('id_cabang', $this->cabangData['id'])->count(),
        ];


        return view('livewire.cabang.info-cabang', $data)
        ->extends('layouts.app');
    }
}
