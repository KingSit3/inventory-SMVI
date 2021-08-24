<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ModelLogCabang extends Model
{
    protected $table = 'log_cabang';
    protected $guarded = [];

    // Ubah data_log menjadi array untuk disimpan ke database
    protected $casts = [
        'data_log' => 'array',
    ];

    public function Cabang()
    {
      return $this->hasOne(ModelCabang::class, 'id', 'id_cabang')->withTrashed();
    }

    public function getTanggalAttribute() 
    {
      return Carbon::parse($this->attributes['created_at'])->format('d-M-Y H:i:s');
    }
}
