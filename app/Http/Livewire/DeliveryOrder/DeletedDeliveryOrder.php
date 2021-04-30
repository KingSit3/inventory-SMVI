<?php

namespace App\Http\Livewire\DeliveryOrder;

use App\Models\DoModel;
use App\Models\LogDeliveryOrder;
use App\Models\Witel;
use Livewire\Component;
use Livewire\WithPagination;

class DeletedDeliveryOrder extends Component
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
            'doData' => DoModel::with('witel')
                                ->onlyTrashed()
                                ->where('no_do', 'like', $keyword)
                                ->orderBy('deleted_at', 'DESC')
                                ->paginate(10),
        ];
        return view('livewire.delivery-order.deleted-delivery-order', $data)
        ->extends('layouts.app');
    }

    public function restore($id) 
    {
        $doQuery = DoModel::where(['id' => $id])->onlyTrashed()->first();
        $witel = Witel::where('id', $doQuery['id_witel'])->first();
        $doQuery->restore();

        LogDeliveryOrder::create([
            'id_do' => $id,
            'data_log' =>   [
                'aksi' => 'Restore',
                'browser' => $_SERVER['HTTP_USER_AGENT'],
                'edited_by' => session('name'),
                'data_lama' =>  [
                            'no_do' => $doQuery['no_do'],
                            'id_witel' => $witel['id'],
                            'nama_witel' => $witel['nama_witel'],
                            'tanggal_do' => $doQuery['tanggal_do'],
                ],
                'data_baru' =>  [],
            ],
        ]);
    }
}
