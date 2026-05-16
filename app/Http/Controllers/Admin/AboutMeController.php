<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\AboutMe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            $validated = array_merge($validated, $this->storeProfileImage($request));
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
            $this->deleteStoredProfileImage($aboutMe);
            $data = array_merge($data, $this->storeProfileImage($request));
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

    /**
     * @return array<string, mixed>
     */
    private function storeProfileImage(Request $request): array
    {
        $file = $request->file('profile_image');
        $path = $file->store('about', 'public');

        return [
            'profile_img' => $path,
            'profile_image_data' => base64_encode(file_get_contents($file->getRealPath())),
            'profile_image_mime' => $file->getMimeType(),
            'profile_image' => null,
        ];
    }

    private function deleteStoredProfileImage(AboutMe $aboutMe): void
    {
        if ($aboutMe->profile_img && ! str_starts_with($aboutMe->profile_img, 'http')) {
            Storage::disk('public')->delete($aboutMe->profile_img);
        }
    }
}
