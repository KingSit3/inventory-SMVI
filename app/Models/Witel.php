<?php

namespace App\Models;

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
      return $this->hasOne(User::class, 'id', 'id_pic');
    }

}
