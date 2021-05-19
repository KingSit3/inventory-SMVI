<?php

namespace App\Http\Livewire\Perangkat;

use App\Models\Perangkat;
use App\Models\DoModel;
use App\Models\Image;
use App\Models\LogPerangkat;
use App\Models\tipePerangkat;
use App\Models\User;
use App\Models\Witel;
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
            'perangkat' => Perangkat::with('users', 'witel', 'DeliveryOrder', 'tipePerangkat', 'image')
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
        $getDataImage = Image::where('id', $getDataPerangkat['id_image'])->withTrashed()->first();

        // get User
        if ($getDataPerangkat['id_user']) {
            $getDataUser = User::where('id', $getDataPerangkat['id_user'])->withTrashed()->first();
        } else {
            $getDataUser = ['id' => null, 'name' => null];
        }

        // Get Witel
        if ($getDataPerangkat['id_witel']) {
            $getDataWitel = Witel::where('id', $getDataPerangkat['id_witel'])->withTrashed()->first();
        } else {
            $getDataWitel = ['id' => null, 'nama_witel' => null];
        }

        // Get DO
        if ($getDataPerangkat['id_do']) {
            $getDataDo = DoModel::where('id', $getDataPerangkat['id_do'])->withTrashed()->first();
        } else {
            $getDataDo = ['id' => null, 'no_do' => null];
        }

        LogPerangkat::create([
            'id_perangkat' => $id,
            'data_log' => [
                            'aksi' => 'Restore',
                            'browser' => $_SERVER['HTTP_USER_AGENT'],
                            'edited_by' => session('name'),
                            'data_lama' =>  [
                                                'sn_lama' => $getDataPerangkat['sn_lama'],
                                                'sn_pengganti' => $getDataPerangkat["sn_pengganti"],
                                                'sn_monitor' => $getDataPerangkat['sn_monitor'],
                                                'id_tipe' => $getDataTipe['id'],
                                                'tipe' => $getDataTipe['kode_perangkat'],
                                                'id_user' => $getDataUser['id'],
                                                'user' => $getDataUser['name'],
                                                'id_image' => $getDataImage['id'],
                                                'image' => $getDataImage['kode_image'],
                                                'id_witel' => $getDataWitel['id'],
                                                'witel' => $getDataWitel['nama_witel'],
                                                'id_delivery_order' => $getDataDo['id'],
                                                'delivery_order' => $getDataDo['no_do'],
                                                'ket' => $getDataPerangkat['keterangan'],
                                                'cek_status' => $getDataPerangkat['cek_status'],
                                                'perolehan' => $getDataPerangkat['perolehan'],
                                                'sp' => $getDataPerangkat['sp'],
                                            ],
                            'data_baru' =>  [],
                        ],
        ]);
    }
}
