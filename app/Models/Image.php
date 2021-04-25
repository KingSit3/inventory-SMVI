<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory;
    protected $table = 'image';
    use SoftDeletes;
    protected $guarded = [];

    public function setKodeImageAttribute($value) 
    {
        $this->attributes['kode_image'] = strtoupper($value);
    }

    public function getTanggalDihapusAttribute($value)
    {
        return $this->attributes['deleted_at'] = Carbon::parse($value)->format('d-M-Y');
    }
}
