<?php

namespace App\Http\Livewire\Pengiriman;

use App\Models\ModelPengiriman;
use App\Models\ModelLogPengiriman;
use App\Models\ModelCabang;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Pengiriman extends Component
{
    use WithPagination;
    public $no_pengiriman, $tanggal, $dbPengiriman, $pengirimanId;
    public $cabang, $cabangSearch, $cabangId, $dbCabang, $cabangData;
    public $submitType, $keyword = '';
    public $isOpen = false;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $keyword = '%'.$this->keyword.'%';

        $hasilCabang = '';
        if (strlen($this->cabangSearch) > 0) {
            $cabangSearchQuery = '%'.$this->cabangSearch.'%';
            $hasilCabang = ModelCabang::where('nama_cabang', 'like', $cabangSearchQuery)->limit(5)->get();
        }

        $data = [
            'cabangResult' => $hasilCabang,
            'pengiriman' => ModelPengiriman::with('cabang')
                                ->where('no_pengiriman', 'like', $keyword)
                                ->orderBy('no_pengiriman', 'desc')
                                ->paginate(10),
        ];

        return view('livewire.pengiriman.pengiriman', $data)
        ->extends('layouts.app');
    }

    public function add() 
    {
        $datapengiriman = ModelPengiriman::orderBy('created_at', 'DESC')->withTrashed()->first();
        $noPengirimanEdit = str_replace('DO-', '', $datapengiriman['no_pengiriman']) + 1;
        $this->no_pengiriman = "DO-".$noPengirimanEdit;
        $this->submitType = 'tambah';
    }

    public function tambah() 
    {
        
        if ($this->tanggal == null) {
            $this->tanggal = Carbon::now();
        }

        $this->validate([
            'no_pengiriman' => 'unique:App\Models\ModelPengiriman,no_pengiriman',
            'cabang' => 'required'
        ]);

        try {
            $savePengiriman = ModelPengiriman::create([
                'no_pengiriman' => $this->no_pengiriman,
                'id_cabang' => $this->cabangData['id'],
                'tanggal_pengiriman' => $this->tanggal,
            ]);

            ModelLogPengiriman::create([
                'id_pengiriman' => $savePengiriman->id,
                'data_log' =>   [
                    'aksi' => 'Tambah',
                    'browser' => $_SERVER['HTTP_USER_AGENT'],
                    'edited_by' => session('nama'),
                    'data_lama' =>  [],
                    'data_baru' =>  [
                                        'no_pengiriman' => $this->no_pengiriman,
                                        'id_cabang' => $this->cabangData['id'],
                                        'nama_cabang' => $this->cabangData['nama_cabang'],
                                        'tanggal_pengiriman' => $this->tanggal,
                                        ],
                ],
            ]);

        } catch (\Exception $ex) {
            // throw $ex;
        }

        // Panggil fungsi Reset data
        $this->resetData();

        // Tutup Modal
        $this->isOpen = false;

        // Panggil SweetAlert berhasil
        $this->emit('success', 'Data pengiriman Berhasil Ditambahkan');
    }

    public function edit($id) 
    {
        $this->submitType = 'update';
        $this->dbPengiriman = ModelPengiriman::with('cabang')->where('id', $id)->first();

        // isi Forms
        $this->pengirimanId = $id;
        $this->no_pengiriman = $this->dbPengiriman['no_pengiriman'];
        $this->tanggal = Carbon::parse($this->dbPengiriman['tanggal_pengiriman'])->format('Y-m-d');
        $this->cabangId = $this->dbPengiriman['cabang']['id'];
        $this->cabang = $this->dbPengiriman['cabang']['nama_cabang'];
    }

    public function update() 
    {
        if ($this->tanggal == null) {
            $this->tanggal = Carbon::now();
        }

        // $oldDataPengiriman = ModelPengiriman::where('id', $this->pengirimanId)->first();
        $this->validate([
            'no_pengiriman' => [Rule::unique('pengiriman', 'no_pengiriman')->ignore($this->no_pengiriman, 'no_pengiriman')],
            'cabang' => 'required'
        ]);

        try {
            ModelPengiriman::where('id', $this->pengirimanId)->update([
                'no_pengiriman' => $this->no_pengiriman,
                'id_cabang' => $this->cabangId,
                'tanggal_pengiriman' => $this->tanggal,
            ]);
            
            $dataCabang = ModelCabang::where('id', $this->cabangId)->first();
            ModelLogPengiriman::create([
                'id_pengiriman' => $this->pengirimanId,
                'data_log' =>   [
                    'aksi' => 'Edit',
                    'browser' => $_SERVER['HTTP_USER_AGENT'],
                    'edited_by' => session('nama'),
                    'data_lama' =>  [
                                        'no_pengiriman' => $this->dbPengiriman['no_pengiriman'],
                                        'id_cabang' => $this->dbPengiriman['cabang']['id'],
                                        'nama_cabang' => $this->dbPengiriman['cabang']['nama_cabang'],
                                        'tanggal_pengiriman' => $this->dbPengiriman['tanggal_pengiriman'],
                    ],
                    'data_baru' =>  [
                                        'no_pengiriman' => $this->no_pengiriman,
                                        'id_cabang' => $dataCabang['id'],
                                        'nama_cabang' => $dataCabang['nama_cabang'],
                                        'tanggal_pengiriman' => $this->tanggal,
                                        ],
                ],
            ]);

        } catch (\Exception $ex) {
            // throw $ex;
            return $this->addError('no_pengiriman', 'No Pengiriman Sudah Ada');
        }

        // Panggil fungsi Reset data
        $this->resetData();

        // Tutup Modal
        $this->isOpen = false;

        // Panggil SweetAlert berhasil
        $this->emit('success', 'Data pengiriman Berhasil diubah');
    }

    public function delete($id)
    {
        $getPengiriman = ModelPengiriman::with('cabang')->where(['id' => $id])->first();
        $getPengiriman->delete();
        
        ModelLogPengiriman::create([
            'id_pengiriman' => $id,
            'data_log' =>   [
                'aksi' => 'Hapus',
                'browser' => $_SERVER['HTTP_USER_AGENT'],
                'edited_by' => session('nama'),
                'data_lama' =>  [
                            'no_pengiriman' => $getPengiriman['no_pengiriman'],
                            'id_cabang' => $getPengiriman['cabang']['id'],
                            'nama_cabang' => $getPengiriman['cabang']['nama_cabang'],
                            'tanggal_pengiriman' => $getPengiriman['tanggal_pengiriman'],
                ],
                'data_baru' =>  [],
            ],
        ]);
    }

    public function chooseCabang($id) 
    {
        $this->cabangData = ModelCabang::where('id', $id)->first();
        $this->cabangId = $this->cabangData['id'];
        $this->cabang = $this->cabangData['kode_cabang'].' | '.$this->cabangData['nama_cabang'];
        $this->reset('cabangSearch');
    }

    public function resetData() 
    {
        $this->resetValidation();
        $this->reset();
    }
}
