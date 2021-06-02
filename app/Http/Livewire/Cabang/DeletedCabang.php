<?php

namespace App\Http\Livewire\Cabang;

use App\Models\ModelLogCabang;
use App\Models\ModelUser as User;
use App\Models\ModelCabang;
use Livewire\Component;
use Livewire\WithPagination;

class DeletedCabang extends Component
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
            'cabang' => ModelCabang::with('users')
                        ->onlyTrashed()
                        ->where('nama_cabang', 'like', $keyword)
                        ->orderBy('deleted_at', 'DESC')
                        ->paginate(10),
        ];

        return view('livewire.cabang.deleted-cabang', $data)
        ->extends('layouts.app');
    }

    public function restore($id) 
    {
        $cabangQuery = ModelCabang::where('id', $id)->onlyTrashed()->first();
        $cabangQuery->restore();

        $dataUser  = User::where('id', $cabangQuery['id_pic'])->withTrashed()->first();
        ModelLogCabang::create([
            'id_cabang' => $id,
            'data_log' => [
                          'aksi' => 'Restore',
                          'browser' => $_SERVER['HTTP_USER_AGENT'],
                          'edited_by' => session('nama'),
                          'data_lama' =>  [
                                              'nama_cabang' => $cabangQuery['nama_cabang'],
                                              'kode_cabang' => $cabangQuery['kode_cabang'],
                                              'alamat_cabang' => $cabangQuery['alamat_cabang'],
                                              'regional' => $cabangQuery['regional'],
                                              'id_pic' => $cabangQuery['id_pic'],
                                              'nama_pic' => $dataUser['nama'],
                                          ],
                          'data_baru' =>  [],
                            ],
          ]);
    }
}
