<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelLogPengiriman extends Model
{
    protected $table = 'log_pengiriman';
    protected $guarded = [];

    // Ubah data_log menjadi array untuk disimpan ke database
    protected $casts = [
        'data_log' => 'array',
    ];

    public function Pengiriman()
    {
      return $this->hasOne(ModelPengiriman::class, 'id', 'id_pengiriman')->withTrashed();
    }

    public function getTanggalAttribute() 
    {
      return date('d-M-Y H:i:s', strtotime($this->attributes['created_at']));
    }

}
