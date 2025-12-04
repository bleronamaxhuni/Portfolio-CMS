<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    
    public function index()
    {
        if (request()->wantsJson()) {
            return response()->json(Project::all());
        }
        return view('admin.projects');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'repository_link' => 'nullable|url|max:255',
            'link' => 'nullable|url|max:255',
            'image' => 'nullable|image|max:2048',
            'category' => 'required|string|max:100',
            'status' => 'required|in:ongoing,completed,paused',
        ]);

        $project = Project::create($validated);

        if ($request->wantsJson()) {
            return response()->json($project, 201);
        }

        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully.');
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $data = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'repository_link' => 'sometimes|nullable|url|max:255',
            'link' => 'sometimes|nullable|url|max:255',
            'image' => 'sometimes|nullable|image|max:2048',
            'category' => 'sometimes|required|string|max:100',
            'status' => 'sometimes|required|in:ongoing,completed,paused',
        ]);

        $project->update($data);

        if ($request->wantsJson()) {
            return response()->json($project, 200);
        }

        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        if (request()->wantsJson()) {
            return response()->json(null, 204);
        }

        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully.');
    }
}
