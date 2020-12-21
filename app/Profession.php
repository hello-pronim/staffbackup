<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    protected $fillable = [
        'title',
        'role_id',
    ];

    public function role()
    {
        return $this->hasOne(Role::class);
    }
}
