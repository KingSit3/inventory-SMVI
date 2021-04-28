<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class LogTipePerangkat extends Model
{
    protected $table = 'log_tipe_perangkat';
    protected $guarded = [];

    // Ubah data_log menjadi array untuk disimpan ke database
    protected $casts = [
        'data_log' => 'array',
    ];

    public function TipePerangkat()
    {
      return $this->hasOne(tipePerangkat::class, 'id', 'id_tipe')->withTrashed();
    }

    public function getTanggalAttribute() 
    {
      return Carbon::parse($this->attributes['created_at'])->format('d-M-Y H:i:s');
    }
}
