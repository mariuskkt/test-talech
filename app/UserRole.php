<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    const ROLE_ADMIN = 0;
    const ROLE_USER = 1;

    public $timestamps = false;

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
