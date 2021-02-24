<?php

namespace App\Models;

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
}
