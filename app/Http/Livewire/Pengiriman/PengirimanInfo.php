<?php

namespace App\Http\Livewire\Pengiriman;

use App\Models\ModelPengiriman;
use App\Models\ModelPerangkat as Perangkat;
use App\Models\ModelCabang as Cabang;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class PengirimanInfo extends Component
{
    use WithPagination;
    public $sn, $tipe, $cabang, $sistem, $dataPerangkat;
    public $pengirimanData, $cariSn;
    public $keyword = '';
    public $isOpen = false;

    // ambil data dari route parameter
    public function mount($id) 
    {
        $this->pengirimanData = ModelPengiriman::where('id', $id)->first();
    }

    public function render()
    {   
        $keyword = '%'.$this->keyword.'%';

        $hasilSn = '';
        if (strlen($this->cariSn) > 0) {
            $cariSnQuery = '%'.$this->cariSn.'%';
            $hasilSn = Perangkat::where('sn_pengganti', 'like', $cariSnQuery)->limit(5)->get();
        }

        $perangkatQuery = Perangkat::with(['users', 'cabang', 'TipePerangkat'])
                            ->where('id_pengiriman', $this->pengirimanData['id'])
                            ->where('sn_pengganti', 'like', $keyword)
                            ->orderBy('updated_at', 'DESC')
                            ->paginate(10);
        $data = [
            'snResult' => $hasilSn,
            'perangkat' => $perangkatQuery,
            'tanggalPengiriman' => Carbon::parse($this->pengirimanData['tanggal_pengiriman'])->format('d-M-Y'),
            'totalPerangkat' => Perangkat::where('id_pengiriman', $this->pengirimanData['id'])->count(),
        ];
        return view('livewire.pengiriman.pengiriman-info', $data)
        ->extends('layouts.app');
    }

    public function delete($id) 
    {
      Perangkat::where('id', $id)->update(['id_pengiriman' => null]);
    }

    public function chooseSn($id) 
    {
      $this->dataPerangkat = Perangkat::where('id', $id)->first();
      if ($this->dataPerangkat['id_cabang'] != null) {
        $dataCabang = Cabang::where('id', $this->dataPerangkat['id_cabang'])->first();
      } else {
        $dataCabang = ['nama_cabang' => null];
      }

      if ($this->dataPerangkat['id_pengiriman'] != null) {
        $this->resetData();
        return $this->addError('cariSn', 'perangkat ada di Pengiriman lain');
      }

      $this->sn = $this->dataPerangkat['sn_pengganti'];
      $this->tipe = $this->dataPerangkat['tipe_perangkat'];
      $this->cabang = $dataCabang['nama_cabang'];
      $this->sistem = $this->dataPerangkat['id_sistem'];
    }

    public function tambah() 
    {
      Perangkat::where('id', $this->dataPerangkat['id'])->update(['id_pengiriman' => $this->pengirimanData['id']]);
      
      // Panggil fungsi Reset data
      $this->resetData();

      // Tutup Modal
      $this->isOpen = false;

      // Panggil SweetAlert berhasil
      $this->emit('success', 'Berhasil Menambahkan Data Perangkat');
    }

    public function resetData() 
    {
      $this->resetValidation();
      $this->reset();
    }
}
