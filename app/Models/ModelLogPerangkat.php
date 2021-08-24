<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ModelLogPerangkat extends Model
{
    protected $table = 'log_perangkat';
    protected $guarded = [];

    // Ubah data_log menjadi array untuk disimpan ke database
    protected $casts = [
        'data_log' => 'array',
    ];

    public function Perangkat()
    {
      return $this->hasOne(ModelPerangkat::class, 'id', 'id_perangkat')->withTrashed();
    }
    
    public function getTanggalAttribute() 
    {
      return Carbon::parse($this->attributes['created_at'])->format('d-M-Y H:i:s');
    }
}
