<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    protected $table = "users";
    use SoftDeletes;
    protected $guarded = [];

    public function setNameAttribute($value)
    {
        return $this->attributes['name'] = ucwords($value);
    }

    // Ubah format deleted_at dengan Accessor
    // Nama bebas, get...(Namabebas)..Attribute
    public function getTanggalDihapusAttribute($value)
    {
        return $this->attributes['deleted_at'] = Carbon::parse($value)->format('d-M-Y');
    }
}
