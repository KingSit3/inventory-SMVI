<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelTipeSistem extends Model
{
    // use HasFactory;
    protected $table = 'tipe_sistem';
    use SoftDeletes;
    protected $guarded = [];

    public function setKodeSistemAttribute($value) 
    {
        $this->attributes['kode_sistem'] = strtoupper($value);
    }

    public function getTanggalDihapusAttribute()
    {
        return date('d-M-Y', strtotime($this->attributes['deleted_at']));
    }
}
