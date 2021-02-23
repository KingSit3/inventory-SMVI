<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class tipePerangkat extends Model
{
    protected $table = 'tipe_perangkat';
    use SoftDeletes;
    protected $guarded = [];

    // Agar kode perangkat semuanya Uppercase
    public function setKodePerangkatAttribute($value) 
    {
      $this->attributes['kode_perangkat'] = strtoupper($value);
    }

    public function setTipePerangkatAttribute($value) 
    {
      $this->attributes['tipe_perangkat'] = strtoupper($value);
    }

    public function getDeletedAtAttribute($value) 
    {
      return $this->attributes['deleted_at'] = Carbon::parse($value)->format('d-M-Y');
    }
}
