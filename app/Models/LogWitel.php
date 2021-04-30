<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class LogWitel extends Model
{
    protected $table = 'log_witel';
    protected $guarded = [];

    // Ubah data_log menjadi array untuk disimpan ke database
    protected $casts = [
        'data_log' => 'array',
    ];

    public function Witel()
    {
      return $this->hasOne(Witel::class, 'id', 'id_witel')->withTrashed();
    }

    public function getTanggalAttribute() 
    {
      return Carbon::parse($this->attributes['created_at'])->format('d-M-Y H:i:s');
    }
}
