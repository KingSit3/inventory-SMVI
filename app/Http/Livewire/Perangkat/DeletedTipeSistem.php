<?php

namespace App\Http\Livewire\Perangkat;

use App\Models\ModelTipeSistem;
use App\Models\ModelLogTipeSistem;
use Livewire\Component;
use Livewire\WithPagination;

class DeletedTipeSistem extends Component
{
    public $keyword = '';
    use WithPagination;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $keyword = '%'.$this->keyword.'%';

        $data = [
            'tipeSistem' => ModelTipeSistem::onlyTrashed()
                                ->where('kode_sistem', 'like', $keyword)
                                ->orderBy('deleted_at', 'DESC')
                                ->paginate(10),
        ];

        return view('livewire.perangkat.deleted-tipe-sistem', $data)
        ->extends('layouts.app');
    }

    public function restore($id) 
    {
        ModelTipeSistem::where('id', $id)->restore();

        $kodeTipeSistem = ModelTipeSistem::where(['id' => $id])->first();
        ModelLogTipeSistem::create([
            'id_sistem' => $id,
            'data_log' =>   [
                                'aksi' => 'Restore',
                                'browser' => $_SERVER['HTTP_USER_AGENT'],
                                'edited_by' => session('nama'),
                                'data_lama' =>  [
                                                    'kode_sistem' => $kodeTipeSistem['kode_sistem'],
                                                ],
                                'data_baru' =>  [],
                            ],
        ]);
    }
}
