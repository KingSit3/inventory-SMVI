<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelCabang extends Model
{
    protected $table = 'cabang';
    protected $guarded = [];
    use SoftDeletes;

    // Joins to user table
    public function Users() 
    {
      return $this->hasOne(ModelUser::class, 'id', 'id_pic')->withTrashed();
    }

    public function getTanggalDihapusAttribute() 
    {
      return date('d-M-Y', strtotime($this->attributes['deleted_at']));
    }

}
