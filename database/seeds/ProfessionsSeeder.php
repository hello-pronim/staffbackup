<?php

use App\Role;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfessionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $freelancer_professions = config('user-professions.freelancer');
        $this->seed($freelancer_professions, Role::FREELANCER_ROLE);

        $employer_professions = config('user-professions.employer');
        $this->seed($employer_professions, Role::EMPLOYER_ROLE);

        $support_professions = config('user-professions.support');
        $this->seed($support_professions, Role::SUPPORT_ROLE);
    }

    /**
     * @param $professions
     * @param $role
     */
    private function seed($professions, $role)
    {
        if (!empty($professions)) {
            foreach ($professions as $profession) {
                DB::table('professions')->insert([
                    'title' => $profession,
                    'role_id' => $role,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
            }
        }
    }
}
