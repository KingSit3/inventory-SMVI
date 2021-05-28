<?php

namespace App\Http\Livewire\Perangkat;

use App\Models\ModelPerangkat as Perangkat;
use App\Models\ModelPengiriman;
use App\Models\ModelLogPerangkat as LogPerangkat;
use App\Models\ModelTipePerangkat as tipePerangkat;
use App\Models\Modeluser as User;
use App\Models\ModelTipeSistem;
use App\Models\ModelCabang;
use Livewire\Component;
use Livewire\WithPagination;

class DeletedPerangkat extends Component
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
            'perangkat' => Perangkat::with('users', 'cabang', 'pengiriman', 'tipePerangkat', 'tipeSistem')
                        ->where('sn_pengganti', 'like', $keyword)
                        ->orderBy('deleted_at', 'DESC')
                        ->onlyTrashed()
                        ->paginate(10),
        ];

        return view('livewire.perangkat.deleted-perangkat', $data)
        ->extends('layouts.app');
    }

    public function restore($id) 
    {
        $getDataPerangkat = Perangkat::where('id', $id)->onlyTrashed()->first();
        $getDataPerangkat->restore();

        $getDataTipe = tipePerangkat::where('id', $getDataPerangkat['id_tipe'])->withTrashed()->first();
        $getDataSistem = ModelTipeSistem::where('id', $getDataPerangkat['id_sistem'])->withTrashed()->first();

        // get User
        if ($getDataPerangkat['id_user']) {
            $getDataUser = User::where('id', $getDataPerangkat['id_user'])->withTrashed()->first();
        } else {
            $getDataUser = ['id' => null, 'nama' => null];
        }

        // Get Cabang
        if ($getDataPerangkat['id_cabang']) {
            $getDataCabang = ModelCabang::where('id', $getDataPerangkat['id_cabang'])->withTrashed()->first();
        } else {
            $getDataCabang = ['id' => null, 'nama_cabang' => null];
        }

        // Get Pengiriman
        if ($getDataPerangkat['id_pengiriman']) {
            $getDataPengiriman = ModelPengiriman::where('id', $getDataPerangkat['id_pengiriman'])->withTrashed()->first();
        } else {
            $getDataPengiriman = ['id' => null, 'no_pengiriman' => null];
        }

        LogPerangkat::create([
            'id_perangkat' => $id,
            'data_log' => [
                            'aksi' => 'Restore',
                            'browser' => $_SERVER['HTTP_USER_AGENT'],
                            'edited_by' => session('nama'),
                            'data_lama' =>  [
                                                'sn_lama' => $getDataPerangkat['sn_lama'],
                                                'sn_pengganti' => $getDataPerangkat["sn_pengganti"],
                                                'sn_monitor' => $getDataPerangkat['sn_monitor'],
                                                'id_tipe' => $getDataTipe['id'],
                                                'tipe' => $getDataTipe['kode_perangkat'],
                                                'id_user' => $getDataUser['id'],
                                                'user' => $getDataUser['nama'],
                                                'id_sistem' => $getDataSistem['id'],
                                                'sistem' => $getDataSistem['kode_sistem'],
                                                'id_cabang' => $getDataCabang['id'],
                                                'cabang' => $getDataCabang['nama_cabang'],
                                                'id_pengiriman' => $getDataPengiriman['id'],
                                                'no_pengiriman' => $getDataPengiriman['no_pengiriman'],
                                                'ket' => $getDataPerangkat['keterangan'],
                                                'cek_status' => $getDataPerangkat['cek_status'],
                                                'perolehan' => $getDataPerangkat['perolehan'],
                                                'gelombang' => $getDataPerangkat['gelombang'],
                                            ],
                            'data_baru' =>  [],
                        ],
        ]);
    }
}
