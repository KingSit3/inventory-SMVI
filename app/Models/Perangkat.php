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

    public function getDeletedAtAttribute($value) 
    {
      return $this->attributes['deleted_at'] = Carbon::parse($value)->format('d-M-Y');
    }

    public function Users() 
    {
      return $this->hasOne(User::class, 'id', 'id_user')->withTrashed();
    }

    public function Witel() 
    {
      return $this->hasOne(Witel::class, 'kode_witel', 'kode_witel')->withTrashed();
    }
}
