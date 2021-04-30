<?php

namespace App\Http\Livewire\Log;

use App\Models\LogDeliveryOrder as ModelsLogDeliveryOrder;
use Livewire\Component;
use Livewire\WithPagination;

class LogDeliveryOrder extends Component
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
        //                                 'no_do' => 'DO-501562',
        //                                 'id_witel' => '2',
        //                                 'nama_witel' => 'ini witel baru',
        //                                 'tanggal_do' => '2021-04-15 02:56:31',
        //                                 ],
        //         ];

        // Edit
        // $dataLog = [
        //                 'aksi' => 'Edit',
        //                 'browser' => $_SERVER['HTTP_USER_AGENT'],
        //                 'edited_by' => session('name'),
        //                 'data_lama' =>  [
        //                                     'no_do' => 'Do lama',
        //                                     'id_witel' => '2',
        //                                     'nama_witel' => 'ini witel lama',
        //                                     'tanggal_do' => '2021-04-15 02:56:31',
        //                                 ],
        //                 'data_baru' =>  [
        //                                     'no_do' => 'Do baru',
        //                                     'nama_witel' => 'ini witel baru',
        //                                     'id_witel' => '1',
        //                                     'tanggal_do' => '2021-05-05 02:56:31',
        //                                 ],
        //         ];

        // Hapus
        // $dataLog = [
            
        //                 'aksi' => 'Hapus',
        //                 'browser' => $_SERVER['HTTP_USER_AGENT'],
        //                 'edited_by' => session('name'),
        //                 'data_lama' =>  [
        //                                     'id_witel' => '2',
        //                                     'nama_witel' => 'ini witel lama',
        //                                     'no_do' => 'Do lama',
        //                                     'tanggal_do' => '2021-04-15 02:56:31',
        //                                 ],
        //                 'data_baru' =>  [],
        //         ];

        // Restore
        // $dataLog = [
            
        //                 'aksi' => 'Restore',
        //                 'browser' => $_SERVER['HTTP_USER_AGENT'],
        //                 'edited_by' => session('name'),
        //                 'data_lama' =>  [
        //                                     'no_do' => 'Do lama',
        //                                     'id_witel' => '2',
        //                                     'nama_witel' => 'ini witel lama',
        //                                     'tanggal_do' => '2021-04-15 02:56:31',
        //                                 ],
        //                 'data_baru' =>  [],
        //         ];
    
        // ModelsLogDeliveryOrder::create([
        //     'id_do' => 2,
        //     'data_log' => $dataLog,
        // ]);
        // die;


        $keyword = '%'.$this->keyword.'%';

        $data = [
            'logDo' => ModelsLogDeliveryOrder::whereHas('deliveryOrder', function($query) use ($keyword){
                                                    // Jalankan query search seperti biasa
                                                    $query->where('no_do', 'like', $keyword);
                                                })
                                                ->orderBy('created_at', 'DESC')
                                                ->paginate(10),
        ];
        return view('livewire.log.log-delivery-order', $data)
        ->extends('layouts.app');
    }
}
