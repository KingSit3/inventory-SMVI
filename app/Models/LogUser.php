<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class LogUser extends Model
{
    protected $table = 'log_user';
    protected $guarded = [];

    // Ubah data_log menjadi array untuk disimpan ke database
    protected $casts = [
        'data_log' => 'array',
    ];

    public function User()
    {
      return $this->hasOne(User::class, 'id', 'id_user')->withTrashed();
    }

    public function getTanggalAttribute() 
    {
      return Carbon::parse($this->attributes['created_at'])->format('d-M-Y H:i:s');
    }
}
