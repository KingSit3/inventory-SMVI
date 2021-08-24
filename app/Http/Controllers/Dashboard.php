<?php

namespace App\Http\Controllers;

use App\Models\ModelCabang;
use App\Models\ModelGelombang;
use App\Models\ModelPengiriman;
use App\Models\ModelPerangkat;
use App\Models\ModelUser;

class Dashboard extends Controller
{
    public function index()
    {
        
        $dataGelombang = ModelGelombang::withCount('perangkat')->get();

        // Ambil data 
        $namaGelombang = collect($dataGelombang)
                        // Hanya nama gelomabng saja
                        ->pluck('nama_gelombang')
                        // Lalu ubah dengan membuat array baru
                        ->transform(function($item){
            return "Gelombang ".$item;
        });

        $totalPerangkat = collect($dataGelombang)->map(function($item){
            return $item->perangkat_count;
        });
        

        $data = [
            'jumlahPerangkat' => ModelPerangkat::count(),
            'jumlahUser' => ModelUser::count(),
            'jumlahCabang' => ModelCabang::count(),
            'jumlahPengiriman' => ModelPengiriman::count(),
            'printPengiriman' => ModelPengiriman::take(5)->orderBy('created_at', 'DESC')->get(),
            'namaGelombang' => $namaGelombang,
            'totalGelombang' => $totalPerangkat,
        ];
        
        return view('dashboard', $data);
    }
}
