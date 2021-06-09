<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelGelombang extends Model
{
    protected $table = 'gelombang';
    protected $guarded = [];

    public function Perangkat() 
    {
      return $this->hasMany(ModelPerangkat::class, 'gelombang', 'nama_gelombang');
    }
}
