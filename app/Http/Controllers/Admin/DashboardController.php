<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\AboutMe;
use App\Models\Admin\Experience;
use App\Models\Admin\Message;
use App\Models\Admin\Project;
use App\Models\Admin\Skill;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (request()->wantsJson()) {
            return response()->json([
                'projects'    => Project::count(),
                'skills'      => Skill::count(),
                'experiences' => Experience::count(),
                'messages'    => Message::count(),
                'about'       => AboutMe::count(),
            ]);
        }

        return view('admin.dashboard');
    }
}
