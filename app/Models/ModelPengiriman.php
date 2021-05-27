<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelPengiriman extends Model
{
    // use HasFactory;
    protected $table = 'pengiriman';
    protected $guarded = [];
    use SoftDeletes;

    public function Cabang() 
    {
      return $this->hasOne(ModelCabang::class, 'id', 'id_cabang')->withTrashed();
    }

    public function getDeletedAtAttribute()
    {
      return date('d-M-Y', strtotime($this->attributes['deleted_at']));
    }

    public function getTanggalPengirimanAttribute()
    {
      return date('d-M-Y', strtotime($this->attributes['tanggal_pengiriman']));
    }

}
