<?php

namespace App\Http\Livewire\Log;

use App\Models\LogTipePerangkat as ModelsLogTipePerangkat;
use Livewire\Component;
use Livewire\WithPagination;

class LogTipePerangkat extends Component
{
    use WithPagination;
    public $keyword = '';

    public function render()
    {
        // Tambah
        // $dataLog = [
        //             'aksi' => 'Tambah',
        //             'browser' => $_SERVER['HTTP_USER_AGENT'],
        //             'edited_by' => session('name'),
        //             'data_lama' =>  [],
        //             'data_baru' =>  [
        //                                 'nama_tipe' => 'MacBook',
        //                                 'tipe_perangkat' => 'KOM',
        //                                 'kode_tipe' => 'NBE-A',
        //                                 ],
        //         ];

        // Edit
        // $dataLog = [
        //                 'aksi' => 'Edit',
        //                 'browser' => $_SERVER['HTTP_USER_AGENT'],
        //                 'edited_by' => session('name'),
        //                 'data_lama' =>  [
        //                                     'nama_tipe' => 'Nama Tipe lama',
        //                                     'tipe_perangkat' => 'Tipe perangkat lama',
        //                                     'kode_tipe' => 'Kode perangkat Lama',
        //                                 ],
        //                 'data_baru' =>  [
        //                                     'nama_tipe' => 'Nama Tipe baru',
        //                                     'tipe_perangkat' => 'Tipe perangkat Baru',
        //                                     'kode_tipe' => 'Kode perangkat Baru',
        //                                 ],
        //         ];

        // Hapus
        // $dataLog = [
            
        //                 'aksi' => 'Hapus',
        //                 'browser' => $_SERVER['HTTP_USER_AGENT'],
        //                 'edited_by' => session('name'),
        //                 'data_lama' =>  [
        //                                     'nama_tipe' => 'Nama Tipe lama',
        //                                     'tipe_perangkat' => 'Tipe perangkat lama',
        //                                     'kode_tipe' => 'Kode perangkat Lama',
        //                                 ],
        //                 'data_baru' =>  [],
        //         ];

        // Restore
        // $dataLog = [
            
        //                 'aksi' => 'Restore',
        //                 'browser' => $_SERVER['HTTP_USER_AGENT'],
        //                 'edited_by' => session('name'),
        //                 'data_lama' =>  [
        //                                     'nama_tipe' => 'Nama Tipe lama',
        //                                     'tipe_perangkat' => 'Tipe perangkat lama',
        //                                     'kode_tipe' => 'Kode perangkat Lama',
        //                                 ],
        //                 'data_baru' =>  [],
        //         ];
    
        // ModelsLogTipePerangkat::create([
        //     'id_tipe' => 1,
        //     'data_log' => $dataLog,
        // ]);
        // die;

        $keyword = '%'.$this->keyword.'%';

        $data = [
                    'logTipe' => ModelsLogTipePerangkat::whereHas('tipePerangkat', function($query) use ($keyword){
                                // Jalankan query search seperti biasa
                                $query->where('kode_perangkat', 'like', $keyword);
                                })
                                ->orderBy('created_at', 'DESC')
                                ->paginate(10),
                ];

        return view('livewire.log.log-tipe-perangkat', $data)
        ->extends('layouts.app');
    }
}
