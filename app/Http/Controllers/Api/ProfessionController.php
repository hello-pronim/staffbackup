<?php

namespace App\Http\Controllers\Api;

use App\Repositories\ProfessionRepository;
use App\Http\Controllers\Controller;

class ProfessionController extends Controller
{
    protected $professionRepository;

    /**
     * ProfessionController constructor.
     * @param ProfessionRepository $professionRepository
     */
    public function __construct(ProfessionRepository $professionRepository)
    {
        $this->professionRepository = $professionRepository;
    }

    /**
     * Get professions by role
     */
    public function index()
    {
        $professions = $this->professionRepository->getProfessionsByRole();
        return response()->json($professions);
    }
}
