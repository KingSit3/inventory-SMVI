<?php

namespace App\Http\Livewire\DeliveryOrder;

use App\Models\DoModel;
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
        DoModel::where('id', $id)->restore();
    }
}
