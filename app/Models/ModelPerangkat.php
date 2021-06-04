<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelPerangkat extends Model
{
    protected $table = 'perangkat';
    protected $guarded = [];
    use SoftDeletes;

    public function setSnPenggantiAttribute($value) 
    {
      return $this->attributes['sn_pengganti'] = strtoupper($value);
    }

    public function getTanggalDihapusAttribute() 
    {
      return date('d-M-Y', strtotime($this->attributes['deleted_at']));
    }

    public function Users() 
    {
      return $this->hasOne(ModelUser::class, 'id', 'id_user')->withTrashed();
    }

    public function Cabang() 
    {
      return $this->hasOne(ModelCabang::class, 'id', 'id_cabang')->withTrashed();
    }

    public function Pengiriman() 
    {
      return $this->hasOne(ModelPengiriman::class, 'id', 'id_pengiriman')->withTrashed();
    }

    public function TipePerangkat() 
    {
      return $this->hasOne(ModelTipePerangkat::class, 'id', 'id_tipe')->withTrashed();
    }

    public function TipeSistem() 
    {
      return $this->hasOne(ModelTipeSistem::class, 'id', 'id_sistem')->withTrashed();
    }
}
