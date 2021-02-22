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

    // Ubah format deleted_at dengan Accessor
    public function getDeletedAtAttribute($value)
    {
        return $this->attributes['deleted_at'] = Carbon::parse($value)->format('d-M-Y');
    }
}
