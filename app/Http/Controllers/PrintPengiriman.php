<?php

namespace App\Http\Controllers;

use App\Models\ModelCabang;
use App\Models\ModelPengiriman;
use App\Models\ModelPerangkat;
use Carbon\Carbon;
use PDF;

class PrintPengiriman extends Controller
{
    public function index($id) 
    {
        $dataPengiriman = ModelPengiriman::where('id', $id)->first();
        $dataTujuan = ModelCabang::with('users')->where('id', $dataPengiriman['id_cabang'])->withTrashed()->first();


        // translatedFormat untuk mengubah ke format yang sudah ditentukan locale
        $tanggalKirim = Carbon::parse($dataPengiriman['tanggal_pengiriman'])->translatedFormat('l, d-F-Y');
        
        $getDataPerangkat = ModelPerangkat::with(['TipePerangkat', 'pengiriman'])->where('id_pengiriman', $id)->withTrashed()->get();
        $totalPerangkat = $getDataPerangkat->count();
        $dataPerangkat = $getDataPerangkat->chunk(50);
        $data = [
            'tanggalKirim' => $tanggalKirim,
            'dataPengiriman' => $dataPengiriman,
            'dataTujuan' => $dataTujuan,
            'perangkat' => $dataPerangkat,
            'totalPerangkat' => $totalPerangkat,
            'namaPerangkat' => $dataPerangkat[0][0]['TipePerangkat']['nama_perangkat'],
        ];
        // dd($dataPengiriman['no_pengiriman']);

        // Untuk Print
        $pdf = PDF::loadView('print-pengiriman', $data)->setPaper('a4', 'portrait');
        return $pdf->download($dataPengiriman['no_pengiriman'].'.pdf');

        // Untuk lihat di web
        return view('print-pengiriman', $data);
    }
}
