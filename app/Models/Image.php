<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    protected $table = 'image';
    use SoftDeletes;
    protected $guarded = [];

    public function setKodeImageAttribute($value) 
    {
        $this->attributes['kode_image'] = strtoupper($value);
    }

    public function getDeletedAtAttribute($value)
    {
        return $this->attributes['deleted_at'] = Carbon::parse($value)->format('d-M-Y');
    }
}
