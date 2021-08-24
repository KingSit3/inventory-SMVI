<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ModelLogTipeSistem extends Model
{
    protected $table = 'log_tipe_sistem';
    protected $guarded = [];

    // Ubah data_log menjadi array untuk disimpan ke database
    protected $casts = [
        'data_log' => 'array',
    ];

    public function TipeSistem()
    {
      return $this->hasOne(ModelTipeSistem::class, 'id', 'id_sistem')->withTrashed();
    }

    public function getTanggalAttribute() 
    {
      // Bebas pakai yang mana
      // return date('d-M-Y H:i:s', strtotime($this->attributes['created_at']));
      
      // Ini juga bisa kok
      return Carbon::parse($this->attributes['created_at'])->format('d-M-Y H:i:s');
    }
}
