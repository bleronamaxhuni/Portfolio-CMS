<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Project;
use App\Traits\ReordersItems;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    use ReordersItems;

    protected function reorderModel(): string
    {
        return Project::class;
    }
    
    public function index()
    {
        if (request()->wantsJson()) {
            return response()->json(Project::query()->orderBy('sort_order')->get());
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

        $validated['sort_order'] = (Project::max('sort_order') ?? -1) + 1;

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
