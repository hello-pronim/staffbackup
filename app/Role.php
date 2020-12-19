<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
        'role_type',
        'guard_name',
    ];

    const ADMIN_ROLE = 1;
    const EMPLOYER_ROLE = 2;
    const FREELANCER_ROLE = 3;
    const SUPPORT_ROLE = 4;

    const ROLES = [
        self::ADMIN_ROLE => 'Admin',
        self::EMPLOYER_ROLE => 'Employer',
        self::FREELANCER_ROLE => 'Freelancer',
        self::SUPPORT_ROLE => 'Support',
    ];
}
