<?php

namespace App\Services;

use App\Job;

class JobService
{
    /**
     * Create job
     *
     * @param $data
     */
    public function create($data)
    {
        Job::create($data);
    }

    public function storeJobs($request)
    {

    }
}