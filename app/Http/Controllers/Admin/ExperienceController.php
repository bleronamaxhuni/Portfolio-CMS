<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function index()
    {
        if (request()->wantsJson()) {
            return response()->json(Experience::all());
        }
        return view('admin.experiences');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_current' => 'sometimes|boolean',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
        ]);

        $validated = $this->normalizeExperienceDates($validated, $request);

        $created = Experience::create($validated);

        if ($request->wantsJson()) {
            return response()->json($created, 201);
        }

        return redirect()->route('admin.experiences.index')->with('success', 'Experience created.');
    }

    public function update(Request $request, $id)
    {
        $experience = Experience::findOrFail($id);

        $data = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'company' => 'sometimes|required|string|max:255',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|nullable|date|after_or_equal:start_date',
            'is_current' => 'sometimes|boolean',
            'description' => 'sometimes|nullable|string',
            'location' => 'sometimes|nullable|string|max:255',
        ]);

        $data = $this->normalizeExperienceDates($data, $request);

        $experience->update($data);

        if ($request->wantsJson()) {
            return response()->json($experience, 200);
        }

        return redirect()->route('admin.experiences.index')->with('success', 'Experience updated.');
    }

    public function destroy($id)
    {
        $experience = Experience::findOrFail($id);
        $experience->delete();

        if (request()->wantsJson()) {
            return response()->json(null, 204);
        }

        return redirect()->route('admin.experiences.index')->with('success', 'Experience deleted.');
    }

    /**
     * @param  array<string, mixed>  $validated
     * @return array<string, mixed>
     */
    private function normalizeExperienceDates(array $validated, Request $request): array
    {
        if ($request->boolean('is_current')) {
            $validated['end_date'] = null;
        }

        unset($validated['is_current']);

        return $validated;
    }
}