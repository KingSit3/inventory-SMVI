<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelUser extends Model
{
    protected $table = "users";
    use SoftDeletes;
    protected $guarded = [];

    public function setNameAttribute($value)
    {
        return $this->attributes['nama'] = ucwords($value);
    }

    public function getTanggalDihapusAttribute()
    {
        return date('d-M-Y', strtotime($this->attributes['deleted_at']));
    }
}
