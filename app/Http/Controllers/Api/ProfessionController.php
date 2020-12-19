<?php

namespace App\Http\Controllers\Api;

use App\Profession;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfessionController extends Controller
{
    /**
     * Get all roles
     */
    public function index()
    {
        $roles = Profession::all();

        return response()->json($roles);
    }
}
