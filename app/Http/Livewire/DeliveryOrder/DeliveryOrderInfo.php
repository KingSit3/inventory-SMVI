<?php

namespace App\Http\Livewire\DeliveryOrder;

use App\Models\DoModel;
use App\Models\Perangkat;
use App\Models\Witel;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class DeliveryOrderInfo extends Component
{
    use WithPagination;
    public $sn, $tipe, $witel, $image, $dataPerangkat;
    public $doData, $cariSn;
    public $keyword = '';
    public $isOpen = false;

    // ambil data dari route parameter
    public function mount($id) 
    {
        $this->doData = DoModel::where('id', $id)->first();
    }

    public function render()
    {   
        $keyword = '%'.$this->keyword.'%';

        $hasilSn = '';
        if (strlen($this->cariSn) > 0) {
            $cariSnQuery = '%'.$this->cariSn.'%';
            $hasilSn = Perangkat::where('sn_pengganti', 'like', $cariSnQuery)->limit(5)->get();
        }

        $perangkatQuery = Perangkat::with(['users', 'witel', 'TipePerangkat'])
                            ->where('id_do', $this->doData['id'])
                            ->where('sn_pengganti', 'like', $keyword)
                            ->orderBy('updated_at', 'DESC')
                            ->paginate(10);
        $data = [
            'snResult' => $hasilSn,
            'perangkat' => $perangkatQuery,
            'tanggalDO' => Carbon::parse($this->doData['tanggal_do'])->format('d-M-Y'),
            'totalPerangkat' => Perangkat::where('id_do', $this->doData['id'])->count(),
        ];
        return view('livewire.delivery-order.delivery-order-info', $data)
        ->extends('layouts.app');
    }

    public function delete($id) 
    {
      Perangkat::where('id', $id)->update(['id_do' => null]);
    }

    public function chooseSn($id) 
    {
      $this->dataPerangkat = Perangkat::where('id', $id)->first();
      if ($this->dataPerangkat['id_witel'] != null) {
        $dataWitel = Witel::where('id', $this->dataPerangkat['id_witel'])->first();
      } else {
        $dataWitel = ['nama_witel' => null];
      }

      if ($this->dataPerangkat['id_do'] != null) {
        $this->resetData();
        return $this->addError('cariSn', 'perangkat ada di DO lain');
      }

      $this->sn = $this->dataPerangkat['sn_pengganti'];
      $this->tipe = $this->dataPerangkat['tipe_perangkat'];
      $this->witel = $dataWitel['nama_witel'];
      $this->image = $this->dataPerangkat['id_image'];
    }

    public function tambah() 
    {
      Perangkat::where('id', $this->dataPerangkat['id'])->update(['id_do' => $this->doData['id']]);
      
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
      $this->reset('cariSn', 'sn', 'tipe', 'witel', 'image');
    }
}
