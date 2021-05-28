<?php

namespace App\Http\Controllers;

use App\Models\Perangkat;
use PDF;

class PrintPengiriman extends Controller
{
    public function index($id) 
    {
        $data = collect(Perangkat::with(['users', 'witel', 'TipePerangkat'])->where('id_do', $id)->get());
        $totalPerangkat = $data->count();
        // $namaPerangkat = $data['tipePerangkat'];
        $dataPerangkat = $data->chunk(3);
        // dump();
        $data = [
            'perangkat' => $dataPerangkat,
            'totalPerangkat' => $totalPerangkat,
            'namaPerangkat' => $dataPerangkat[0][0]['TipePerangkat']['nama_perangkat'],
        ];

        // Untuk Print
        // $pdf = PDF::loadView('printDo', $data)->setPaper('a4', 'portrait');
        // return $pdf->download('printDo.pdf');

        // Untuk lihat di web
        return view('printDo', $data);
    }
}
