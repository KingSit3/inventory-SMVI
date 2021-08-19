<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ModelPengguna extends Model
{
    protected $table = 'pengguna';
    protected $guarded = [];

    // Buat format date dengan Carbon untuk Last Login
    public function getLastLoginAttribute($value)
    {
        return $this->attributes['updated_at'] = Carbon::parse($value)->diffForHumans();
    }
}