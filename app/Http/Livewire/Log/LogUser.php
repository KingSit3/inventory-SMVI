<?php

namespace App\Http\Livewire\Log;

use App\Models\LogUser as ModelsLogUser;
use Livewire\Component;
use Livewire\WithPagination;

class LogUser extends Component
{
    use WithPagination;
    public $keyword = '';
    
    public function render()
    {
        // Tambah
            // // $dataLog = [
            // //             'aksi' => 'Tambah',
            // //             'browser' => $_SERVER['HTTP_USER_AGENT'],
            // //             'edited_by' => session('name'),
            // //             'data_lama' =>  [],
            // //             'data_baru' =>  [
            // //                                 'name' => 'Nama User Baru',
            // //                                 'nik' => '',
            // //                                 'no_telp' => 'no_telp Baru',
            // //                                 ],
            // //         ];

            // // // // Edit
            // $dataLog = [
            //                 'aksi' => 'Edit',
            //                 'browser' => $_SERVER['HTTP_USER_AGENT'],
            //                 'edited_by' => session('name'),
            //                 'data_lama' =>  [
            //                                     'name' => 'Nama User Lama',
            //                                     'nik' => 'NIK Lama',
            //                                     'no_telp' => 'no_telp Lama',
            //                                 ],
            //                 'data_baru' =>  [
            //                                     'name' => 'Nama User Baru',
            //                                     'nik' => 'NIK Baru',
            //                                     'no_telp' => 'no_telp Baru',
            //                                 ],
            //         ];

            // // // // Hapus
            // $dataLog = [
                
            //                 'aksi' => 'Hapus',
            //                 'browser' => $_SERVER['HTTP_USER_AGENT'],
            //                 'edited_by' => session('name'),
            //                 'data_lama' =>  [
            //                                     'name' => 'Nama User Lama',
            //                                     'nik' => 'NIK Lama',
            //                                     'no_telp' => 'no_telp Lama',
            //                                 ],
            //                 'data_baru' =>  [],
            //         ];

            // // // // Restore
            // $dataLog = [
                
            //                 'aksi' => 'Restore',
            //                 'browser' => $_SERVER['HTTP_USER_AGENT'],
            //                 'edited_by' => session('name'),
            //                 'data_lama' =>  [
            //                                     'name' => 'Nama User Lama',
            //                                     'nik' => 'NIK Lama',
            //                                     'no_telp' => 'no_telp Lama',
            //                                 ],
            //                 'data_baru' =>  [],
            //         ];
        
            // ModelsLogUser::create([
            //     'id_user' => 2,
            //     'data_log' => $dataLog,
            // ]);
            // die;


        $keyword = '%'.$this->keyword.'%';

        $data = [
            'logUser' => ModelsLogUser::whereHas('User', function($query) use ($keyword){
                // Jalankan query search seperti biasa
                $query->where('name', 'like', $keyword);
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(10),
        ];
        return view('livewire.log.log-user', $data)
        ->extends('layouts.app');
    }
}
