<?php

namespace App\Http\Livewire\Witel;

use App\Models\LogWitel;
use App\Models\User;
use App\Models\Witel;
use Livewire\Component;
use Livewire\WithPagination;

class DeletedWitel extends Component
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
            'witel' => Witel::onlyTrashed()
                        ->where('nama_witel', 'like', $keyword)
                        ->orderBy('deleted_at', 'DESC')
                        ->paginate(10),
        ];

        return view('livewire.witel.deleted-witel', $data)
        ->extends('layouts.app');
    }

    public function restore($id) 
    {
        $witelQuery = Witel::where('id', $id)->withTrashed()->first();
        $witelQuery->restore();

        $dataUser  = User::where('id', $witelQuery['id_pic'])->withTrashed()->first();
        LogWitel::create([
            'id_witel' => $id,
            'data_log' => [
                          'aksi' => 'Restore',
                          'browser' => $_SERVER['HTTP_USER_AGENT'],
                          'edited_by' => session('name'),
                          'data_lama' =>  [
                                              'nama_witel' => $witelQuery['nama_witel'],
                                              'kode_witel' => $witelQuery['kode_witel'],
                                              'alamat_witel' => $witelQuery['alamat_witel'],
                                              'regional_witel' => $witelQuery['regional'],
                                              'id_pic' => $witelQuery['id_pic'],
                                              'nama_pic' => $dataUser['name'],
                                          ],
                          'data_baru' =>  [],
                            ],
          ]);
    }
}
