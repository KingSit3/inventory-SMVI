<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function getDeletedAtAttribute()
    {
      return date('d-M-Y', strtotime($this->attributes['deleted_at']));
    }

    public function getTanggalDoAttribute() 
    {
      return date('d-M-Y', strtotime($this->attributes['tanggal_do']));
    }

}
