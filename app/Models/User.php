<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    protected $table = "users";
    use SoftDeletes;
    protected $guarded = [];
}
