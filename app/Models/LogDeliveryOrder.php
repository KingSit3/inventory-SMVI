<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogDeliveryOrder extends Model
{
    protected $table = 'log_delivery_order';
    protected $guarded = [];

    // Ubah data_log menjadi array untuk disimpan ke database
    protected $casts = [
        'data_log' => 'array',
    ];

    public function DeliveryOrder()
    {
      return $this->hasOne(DoModel::class, 'id', 'id_do')->withTrashed();
    }

    public function getTanggalAttribute() 
    {
      return date('d-M-Y H:i:s', strtotime($this->attributes['created_at']));
    }

}
