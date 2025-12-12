<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Admin\AboutMe;
use App\Models\Admin\Experience;
use App\Models\Admin\Project;
use App\Models\Admin\Skill;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $about = AboutMe::first();
        $experiences = Experience::all();
        $skills = Skill::all();
        $projects = Project::all();

        return view('client.index', compact('about', 'experiences', 'skills', 'projects'));
    }
}
