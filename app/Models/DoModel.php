<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DoModel extends Model
{
    // use HasFactory;
    protected $table = 'tbl_do';
    protected $guarded = [];
    use SoftDeletes;

    public function Witel() 
    {
      return $this->hasOne(Witel::class, 'id', 'id_witel')->withTrashed();
    }

    public function getDeletedAtAttribute($value)
    {
        return $this->attributes['deleted_at'] = Carbon::parse($value)->format('d-M-Y');
    }

    public function getTanggalDoAttribute($value) 
    {
      return $this->attributes['tanggal_do'] = Carbon::parse($value)->format('d-M-Y');
    }

}
