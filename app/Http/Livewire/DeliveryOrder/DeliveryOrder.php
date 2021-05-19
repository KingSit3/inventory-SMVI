<?php

namespace App\Http\Livewire\DeliveryOrder;

use App\Models\DoModel;
use App\Models\LogDeliveryOrder;
use App\Models\Witel;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class DeliveryOrder extends Component
{
    use WithPagination;
    public $no_do, $tanggal, $dbDo, $doId;
    public $witel, $witelSearch, $witelId, $dbWitel, $oldDataWitel;
    public $submitType, $keyword = '';
    public $isOpen = false;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $keyword = '%'.$this->keyword.'%';

        $hasilWitel = '';
        if (strlen($this->witelSearch) > 0) {
            $witelSearchQuery = '%'.$this->witelSearch.'%';
            $hasilWitel = Witel::where('nama_witel', 'like', $witelSearchQuery)->limit(5)->get();
        }

        $data = [
            'witelResult' => $hasilWitel,
            'deliveryOrder' => DoModel::with('witel')
                                ->where('no_do', 'like', $keyword)
                                ->orderBy('no_do', 'desc')
                                ->paginate(10),
        ];

        return view('livewire.delivery-order.delivery-order', $data)
        ->extends('layouts.app');
    }

    public function add() 
    {
        $dataDo = DoModel::orderBy('created_at', 'DESC')->first();
        $noDoEdit = str_replace('DO-', '', $dataDo['no_do']) + 1;
        $this->no_do = "DO-".$noDoEdit;
        $this->submitType = 'tambah';
    }

    public function tambah() 
    {
        
        if ($this->tanggal == null) {
            $this->tanggal = Carbon::now();
        }

        $this->validate([
            'no_do' => 'unique:App\Models\DoModel,no_do',
            'witel' => 'required'
        ]);

        try {
            DoModel::create([
                'no_do' => $this->no_do,
                'id_witel' => $this->witelId,
                'tanggal_do' => $this->tanggal,
            ]);

            // get Id Do
            $idDo = DoModel::latest()->first();
            // // Get Witel Data
            $witelData = Witel::where('id', $this->witelId)->first();
            // // dd($witelData);
            LogDeliveryOrder::create([
                'id_do' => $idDo['id'],
                'data_log' =>   [
                    'aksi' => 'Tambah',
                    'browser' => $_SERVER['HTTP_USER_AGENT'],
                    'edited_by' => session('name'),
                    'data_lama' =>  [],
                    'data_baru' =>  [
                                        'no_do' => $this->no_do,
                                        'id_witel' => $witelData['id'],
                                        'nama_witel' => $witelData['nama_witel'],
                                        'tanggal_do' => $this->tanggal,
                                        ],
                ],
            ]);

        } catch (\Illuminate\Validation\ValidationException $ex) {
            // return $ex;
        }

        // Panggil fungsi Reset data
        $this->resetData();

        // Tutup Modal
        $this->isOpen = false;

        // Panggil SweetAlert berhasil
        $this->emit('success', 'Data DO Berhasil Ditambahkan');
        
    }

    public function edit($id) 
    {
        $this->submitType = 'update';
        $this->dbDo = DoModel::where('id', $id)->first();
        $this->dbWitel = Witel::where('id', $this->dbDo['id_witel'])->first();

        $this->doId = $id;
        $this->no_do = $this->dbDo['no_do'];
        $this->tanggal = Carbon::parse($this->dbDo['tanggal_do'])->format('Y-m-d');
        $this->witelId = $this->dbDo['id_witel'];
        $this->witel = $this->dbWitel['nama_witel'];

        
        $this->oldDataWitel = Witel::where('id', $this->dbDo['id_witel'])->first();
    }

    public function update() 
    {
        if ($this->tanggal == null) {
            $this->tanggal = Carbon::now();
        } 

        $oldDataDo = DoModel::where('id', $this->doId)->first();
        $this->validate([
            'no_do' => [Rule::unique('tbl_do', 'no_do')->ignore($this->no_do, 'no_do')],
            'witel' => 'required'
        ]);

        try {
            DoModel::where('id', $this->doId)->update([
                'no_do' => $this->no_do,
                'id_witel' => $this->witelId,
                'tanggal_do' => $this->tanggal,
            ]);
            
            $dataWitel = Witel::where('id', $this->witelId)->first();
            LogDeliveryOrder::create([
                'id_do' => $this->doId,
                'data_log' =>   [
                    'aksi' => 'Edit',
                    'browser' => $_SERVER['HTTP_USER_AGENT'],
                    'edited_by' => session('name'),
                    'data_lama' =>  [
                                'no_do' => $oldDataDo['no_do'],
                                'id_witel' => $this->oldDataWitel['id'],
                                'nama_witel' => $this->oldDataWitel['nama_witel'],
                                'tanggal_do' => $oldDataDo['tanggal_do'],
                    ],
                    'data_baru' =>  [
                                        'no_do' => $this->no_do,
                                        'id_witel' => $dataWitel['id'],
                                        'nama_witel' => $dataWitel['nama_witel'],
                                        'tanggal_do' => $this->tanggal,
                                        ],
                ],
            ]);

        } catch (\Exception $ex) {
            return $ex;
        }

        // Panggil fungsi Reset data
        $this->resetData();

        // Tutup Modal
        $this->isOpen = false;

        // Panggil SweetAlert berhasil
        $this->emit('success', 'Data DO Berhasil diubah');
    }

    public function delete($id)
    {
        $doQuery = DoModel::where(['id' => $id])->first();
        $witel = Witel::where('id', $doQuery['id_witel'])->first();
        $doQuery->delete();

         
        LogDeliveryOrder::create([
            'id_do' => $id,
            'data_log' =>   [
                'aksi' => 'Hapus',
                'browser' => $_SERVER['HTTP_USER_AGENT'],
                'edited_by' => session('name'),
                'data_lama' =>  [
                            'no_do' => $doQuery['no_do'],
                            'id_witel' => $witel['id'],
                            'nama_witel' => $witel['nama_witel'],
                            'tanggal_do' => $doQuery['tanggal_do'],
                ],
                'data_baru' =>  [],
            ],
        ]);
    }

    public function chooseWitel($id) 
    {
        $witelData = Witel::where('id', $id)->first();
        $this->witelId = $witelData['id'];
        $this->witel = $witelData['kode_witel'].' | '.$witelData['nama_witel'];
        $this->reset('witelSearch');
    }

    public function resetData() 
    {
        $this->resetValidation();
        $this->reset('submitType', 'no_do', 'tanggal', 'witelId', 'witel', 'tanggal', 'witelSearch', 'oldDataWitel');
    }
}
