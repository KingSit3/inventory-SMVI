<?php

namespace App\Http\Livewire\Pengiriman;

use App\Models\ModelPengiriman;
use App\Models\ModelLogPengiriman;
use Livewire\Component;
use Livewire\WithPagination;

class DeletedPengiriman extends Component
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
            'pengiriman' => ModelPengiriman::with('cabang')
                                ->onlyTrashed()
                                ->where('no_pengiriman', 'like', $keyword)
                                ->orderBy('deleted_at', 'DESC')
                                ->paginate(10),
        ];
        return view('livewire.pengiriman.deleted-pengiriman', $data)
        ->extends('layouts.app');
    }

    public function restore($id) 
    {
        $query = ModelPengiriman::with('cabang')->where(['id' => $id])->onlyTrashed()->first();
        $query->restore();

        ModelLogPengiriman::create([
            'id_pengiriman' => $id,
            'data_log' =>   [
                'aksi' => 'Restore',
                'browser' => $_SERVER['HTTP_USER_AGENT'],
                'edited_by' => session('nama'),
                'data_lama' =>  [
                            'no_pengiriman' => $query['no_pengiriman'],
                            'id_cabang' => $query['cabang']['id'],
                            'nama_cabang' => $query['cabang']['nama_cabang'],
                            'tanggal_pengiriman' => $query['tanggal_pengiriman'],
                ],
                'data_baru' =>  [],
            ],
        ]);
    }
}
