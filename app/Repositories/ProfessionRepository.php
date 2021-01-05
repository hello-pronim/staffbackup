<?php

namespace App\Repositories;

use App\Profession;
use App\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class ProfessionRepository
{
    /**
     * Get professions by auth user role
     * @return Collection
     */
    public function getProfessionsByRole(): Collection
    {
        $auth_user_role_id = Auth::user()->roles[0]->id;

        if ($auth_user_role_id == Role::EMPLOYER_ROLE) {
            $professions = Profession::where('role_id', Role::EMPLOYER_ROLE)->get();
        } else if ($auth_user_role_id == Role::FREELANCER_ROLE) {
            $professions = Profession::where('role_id', Role::FREELANCER_ROLE)->get();
        } else if ($auth_user_role_id == Role::SUPPORT_ROLE) {
            $professions = Profession::where('role_id', Role::SUPPORT_ROLE)->get();
        } else {
            $professions = Profession::all();
        }

        return $professions;
    }
}