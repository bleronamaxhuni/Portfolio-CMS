<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        if (request()->wantsJson()) {
            return response()->json(Skill::all());
        }
        return view('admin.skills');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'proficiency_level' => 'required|string|max:256',
            'icon' => 'nullable|string|max:255',
        ]);

        $skill = Skill::create($validated);

        if ($request->wantsJson()) {
            return response()->json($skill, 201);
        }
    }


    public function update(Request $request, $id)
    {
        $skill = Skill::findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'proficiency_level' => 'sometimes|required|string|max:256',
            'icon' => 'sometimes|nullable|string|max:255',
        ]);

        $skill->update($data);

        if ($request->wantsJson()) {
            return response()->json($skill, 200);
        }
    }


    public function destroy($id)
    {
        $skill = Skill::findOrFail($id);
        $skill->delete();

        if (request()->wantsJson()) {
            return response()->json(null, 204);
        }
    }
}
