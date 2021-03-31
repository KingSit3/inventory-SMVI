<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Witel extends Model
{
    protected $table = 'witel';
    protected $guarded = [];
    use SoftDeletes;

    // Joins to user table
    public function Users() 
    {
      return $this->hasOne(User::class, 'id', 'id_pic')->withTrashed();
    }

    public function getDeletedAtAttribute($value) 
    {
      return $this->attributes['deleted_at'] = Carbon::parse($value)->format('d-M-Y');
    }

}
