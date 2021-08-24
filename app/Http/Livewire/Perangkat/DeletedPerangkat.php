<?php

namespace App\Http\Livewire\Perangkat;

use App\Models\ModelPerangkat as Perangkat;
use App\Models\ModelLogPerangkat as LogPerangkat;
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
        $getDataPerangkat = Perangkat::with('users', 'cabang', 'pengiriman', 'tipePerangkat', 'tipeSistem')
                                        ->where(['id' => $id])
                                        ->onlyTrashed()
                                        ->first();

        // get User
        if (!$getDataPerangkat['id_user']) {
            $getDataUser = [
                                'id' => null, 
                                'nama' => null
                            ];
        } else {
            $getDataUser = [
                                'id' => $getDataPerangkat['users']['id'], 
                                'nama' => $getDataPerangkat['users']['nama']
                            ];
        }

        // Get Cabang
        if (!$getDataPerangkat['id_cabang']) {
            $getDataCabang = [
                                'id' => null, 
                                'nama_cabang' => null
                            ];
        } else {
            $getDataCabang = [
                                'id' => $getDataPerangkat['cabang']['id'], 
                                'nama_cabang' => $getDataPerangkat['cabang']['nama_cabang']
                            ];
        }

        // Get Pengiriman
        if (!$getDataPerangkat['id_pengiriman']) {
            $getDataPengiriman = [
                                'id' => null, 
                                'no_pengiriman' => null
                            ];
        } else {
            $getDataPengiriman = [
                                'id' => $getDataPerangkat['pengiriman']['id'], 
                                'no_pengiriman' => $getDataPerangkat['pengiriman']['no_pengiriman']
                            ];
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
                                                'id_tipe' => $getDataPerangkat['tipePerangkat']['id'],
                                                'tipe' => $getDataPerangkat['tipePerangkat']['kode_perangkat'],
                                                'id_user' => $getDataUser['id'],
                                                'user' => $getDataUser['nama'],
                                                'id_sistem' => $getDataPerangkat['tipeSistem']['id'],
                                                'sistem' => $getDataPerangkat['tipeSistem']['kode_sistem'],
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

        $getDataPerangkat->restore();
    }
}
