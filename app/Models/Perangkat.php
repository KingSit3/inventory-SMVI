<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Perangkat extends Model
{
    // use HasFactory;

    protected $table = 'perangkat';
    protected $guarded = [];
    use SoftDeletes;

    public function setSnPenggantiAttribute($value) 
    {
      return $this->attributes['sn_pengganti'] = strtoupper($value);
    }

    public function setSnMonitorAttribute($value) 
    {
      return $this->attributes['sn_monitor'] = strtoupper($value);
    }

    public function setSnLamaAttribute($value) 
    {
      return $this->attributes['sn_lama'] = strtoupper($value);
    }

    public function getTanggalDihapusAttribute($value) 
    {
      return $this->attributes['deleted_at'] = Carbon::parse($value)->format('d-M-Y');
    }

    public function Users() 
    {
      return $this->hasOne(User::class, 'id', 'id_user')->withTrashed();
    }

    public function Witel() 
    {
      return $this->hasOne(Witel::class, 'id', 'id_witel')->withTrashed();
    }

    public function DeliveryOrder() 
    {
      return $this->hasOne(DoModel::class, 'id', 'id_do')->withTrashed();
    }

    public function TipePerangkat() 
    {
      return $this->hasOne(tipePerangkat::class, 'id', 'id_tipe')->withTrashed();
    }

    public function Image() 
    {
      return $this->hasOne(Image::class, 'id', 'id_image')->withTrashed();
    }
}
