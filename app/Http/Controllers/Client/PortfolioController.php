<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Admin\AboutMe;
use App\Models\Admin\Experience;
use App\Models\Admin\Project;
use App\Models\Admin\Skill;

class PortfolioController extends Controller
{
    public function index()
    {
        return response()->json([
            'about' => AboutMe::query()->first(),
            'experiences' => Experience::query()->orderByDesc('start_date')->get(),
            'skills' => Skill::query()->orderBy('id')->get(),
            'projects' => Project::query()->orderByDesc('created_at')->get(),
        ]);
    }
}
