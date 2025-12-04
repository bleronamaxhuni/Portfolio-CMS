<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\AboutMe;
use Illuminate\Http\Request;

class AboutMeController extends Controller
{
    public function index()
    {
        if (request()->wantsJson()) {
            return response()->json(AboutMe::all());
        }

        return view('admin.aboutme');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bio' => 'required|string',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'resume_link' => 'nullable|url|max:255',
        ]);

        if ($request->hasFile('profile_image')) {
            $validated['profile_image'] = $request->file('profile_image')->store('about', 'public');
        }

        $created = AboutMe::create($validated);

        return $request->wantsJson()
            ? response()->json($created, 201)
            : redirect()->route('admin.about-me.index')->with('success', 'Created.');
    }

    public function update(Request $request, $id)
    {
        $aboutMe = AboutMe::findOrFail($id);

        $data = $request->validate([
            'bio' => 'sometimes|required|string',
            'profile_image' => 'sometimes|nullable|image|mimes:jpg,jpeg,png|max:2048',
            'resume_link' => 'sometimes|nullable|url|max:255',
        ]);

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request->file('profile_image')->store('about', 'public');
        }

        $aboutMe->update($data);

        return $request->wantsJson()
        ? response()->json($aboutMe, 200)
        : redirect()->route('admin.about-me.index')->with('success', 'Updated.');
    
    }

    public function destroy($id)
    {
        $aboutMe = AboutMe::findOrFail($id);
        $aboutMe->delete();

        if (request()->wantsJson()) {
            return response()->json(null, 204);
        }

        return redirect()->route('admin.about-me.index')->with('success', 'About Me deleted.');
    }
}
