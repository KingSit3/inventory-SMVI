<?php

namespace App\Http\Livewire\Log;

use App\Models\LogWitel as ModelsLogWitel;
use Livewire\Component;
use Livewire\WithPagination;

class LogWitel extends Component
{
    use WithPagination;
    public $keyword = '';

    public function render()
    {
        $keyword = '%'.$this->keyword.'%';

            // Tambah
            // $dataLog = [
            //             'aksi' => 'Tambah',
            //             'browser' => $_SERVER['HTTP_USER_AGENT'],
            //             'edited_by' => session('name'),
            //             'data_lama' =>  [],
            //             'data_baru' =>  [
            //                                 'nama_witel' => 'Nama Witel Baru',
            //                                 'kode_witel' => 'Kode Witel Baru',
            //                                 'alamat_witel' => 'Alamat Witel Baru',
            //                                 'regional_witel' => 'Regional Witel Baru',
            //                                 'id_pic' => '2',
            //                                 'nama_pic' => 'PrasetyoWidodo',
            //                                 ],
            //         ];

            // // // Edit
            // $dataLog = [
            //                 'aksi' => 'Edit',
            //                 'browser' => $_SERVER['HTTP_USER_AGENT'],
            //                 'edited_by' => session('name'),
            //                 'data_lama' =>  [
            //                                     'nama_witel' => 'Nama Witel Lama',
            //                                     'kode_witel' => 'Kode Witel Lama',
            //                                     'alamat_witel' => 'Alamat Witel Lama',
            //                                     'regional_witel' => 'Regional Witel Lama',
            //                                     'id_pic' => '2',
            //                                     'nama_pic' => 'PrasetyoWidodo',
            //                                 ],
            //                 'data_baru' =>  [
            //                                     'nama_witel' => 'Nama Witel Baru',
            //                                     'kode_witel' => 'Kode Witel Baru',
            //                                     'alamat_witel' => 'Alamat Witel Baru',
            //                                     'regional_witel' => 'Regional Witel Baru',
            //                                     'id_pic' => '1',
            //                                     'nama_pic' => 'SUPRIYANTO',
            //                                 ],
            //         ];

            // // // Hapus
            // $dataLog = [
                
            //                 'aksi' => 'Hapus',
            //                 'browser' => $_SERVER['HTTP_USER_AGENT'],
            //                 'edited_by' => session('name'),
            //                 'data_lama' =>  [
            //                                     'nama_witel' => 'Nama Witel Lama',
            //                                     'kode_witel' => 'Kode Witel Lama',
            //                                     'alamat_witel' => 'Alamat Witel Lama',
            //                                     'regional_witel' => 'Regional Witel Lama',
            //                                     'id_pic' => '2',
            //                                     'nama_pic' => 'PrasetyoWidodo',
            //                                 ],
            //                 'data_baru' =>  [],
            //         ];

            // // // Restore
            // $dataLog = [
                
            //                 'aksi' => 'Restore',
            //                 'browser' => $_SERVER['HTTP_USER_AGENT'],
            //                 'edited_by' => session('name'),
            //                 'data_lama' =>  [
            //                                     'nama_witel' => 'Nama Witel Lama',
            //                                     'kode_witel' => 'Kode Witel Lama',
            //                                     'alamat_witel' => 'Alamat Witel Lama',
            //                                     'regional_witel' => 'Regional Witel Lama',
            //                                     'id_pic' => '2',
            //                                     'nama_pic' => 'PrasetyoWidodo',
            //                                 ],
            //                 'data_baru' =>  [],
            //         ];
        
            // ModelsLogWitel::create([
            //     'id_witel' => 2,
            //     'data_log' => $dataLog,
            // ]);
            // die;

            $data = [
                'logDo' => ModelsLogWitel::whereHas('Witel', function($query) use ($keyword){
                    // Jalankan query search seperti biasa
                    $query->where('nama_witel', 'like', $keyword);
                })
                ->orderBy('created_at', 'DESC')
                ->paginate(10),
            ];

            return view('livewire.log.log-witel', $data)
            ->extends('layouts.app');
    }
}
