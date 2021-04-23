<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SP extends Model
{
    protected $table = 'sp';
    protected $guarded = [];

    use SoftDeletes;

    public function getDeletedAtAttribute($value) 
    {
      return $this->attributes['deleted_at'] = Carbon::parse($value)->format('d-M-Y');
    }
}
