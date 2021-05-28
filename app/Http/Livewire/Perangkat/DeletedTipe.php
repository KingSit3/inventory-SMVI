<?php

namespace App\Http\Livewire\Perangkat;

use App\Models\ModelLogTipePerangkat as LogTipePerangkat;
use App\Models\ModelTipePerangkat as tipePerangkat;
use Livewire\Component;
use Livewire\WithPagination;

class DeletedTipe extends Component
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
            'tipe_perangkat' => tipePerangkat::onlyTrashed()
                                ->where('kode_perangkat', 'like', $keyword)
                                // ->orWhere('nama_perangkat', 'like', $keyword)
                                ->orderBy('deleted_at', 'DESC')
                                ->paginate(10),
        ];

        return view('livewire.perangkat.deleted-tipe-perangkat', $data)
        ->extends('layouts.app');
    }

    public function restore($id) 
    {
        $tipeQuery = tipePerangkat::where('id', $id)->onlyTrashed()->first();
        $tipeQuery->restore();

        LogTipePerangkat::create([
            'id_tipe' => $id,
            'data_log' =>   [
                                'aksi' => 'Restore',
                                'browser' => $_SERVER['HTTP_USER_AGENT'],
                                'edited_by' => session('nama'),
                                'data_lama' =>  [
                                                    'nama_tipe' => $tipeQuery['nama_perangkat'],
                                                    'tipe_perangkat' => $tipeQuery['tipe_perangkat'],
                                                    'kode_tipe' => $tipeQuery['kode_perangkat'],
                                                ],
                                'data_baru' =>  [],
                            ],
        ]);
    }
}
