<?php

namespace App\Http\Livewire\Pengiriman;

use App\Models\ModelPengiriman;
use App\Models\ModelPerangkat as Perangkat;
use Livewire\Component;
use Livewire\WithPagination;

class PengirimanInfo extends Component
{
    use WithPagination;
    public $sn, $tipe, $cabang, $sistem, $dataPerangkat;
    public $pengirimanData, $cariSn, $totalPerangkat;
    public $keyword = '';
    public $isOpen = false;

    // ambil data dari route parameter
    public function mount($id) 
    {
        $this->pengirimanData = ModelPengiriman::where('id', $id)->withTrashed()->first();
    }

    public function render()
    {   
        $keyword = '%'.$this->keyword.'%';
        $this->totalPerangkat = Perangkat::where('id_pengiriman', $this->pengirimanData['id'])->withTrashed()->count(); 

        $hasilSn = '';
        if (strlen($this->cariSn) > 0) {
            $cariSnQuery = '%'.$this->cariSn.'%';
            $hasilSn = Perangkat::where('sn_pengganti', 'like', $cariSnQuery)->limit(5)->get();
        }

        $perangkatQuery = Perangkat::with(['users', 'cabang', 'TipePerangkat'])
                            ->where('id_pengiriman', $this->pengirimanData['id'])
                            ->where('sn_pengganti', 'like', $keyword)
                            ->orderBy('updated_at', 'DESC')
                            ->withTrashed()
                            ->paginate(10);
        $data = [
            'snResult' => $hasilSn,
            'perangkat' => $perangkatQuery,
            'tanggalPengiriman' => date('d-M-Y', strtotime($this->pengirimanData['tanggal_pengiriman'])),
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
      $this->dataPerangkat = Perangkat::with('cabang', 'TipePerangkat', 'TipeSistem')->where('id', $id)->first();

      if ($this->dataPerangkat['id_pengiriman'] != null) {
        $this->reset('cariSn');
        return $this->addError('cariSn', 'perangkat ada di Pengiriman lain');
      }

      $this->sn = $this->dataPerangkat['sn_pengganti'];
      $this->tipe = $this->dataPerangkat['TipePerangkat']['nama_perangkat'];
      $this->cabang = ($this->dataPerangkat['cabang']['nama_cabang']) ? $this->dataPerangkat['cabang']['nama_cabang'] : '-';
      $this->sistem = $this->dataPerangkat['TipeSistem']['kode_sistem'];
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
      $this->reset('sn', 'tipe', 'cabang', 'sistem', 'dataPerangkat', 'cariSn', 'keyword');
    }
}
