<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\DonaturProfile;
use App\Models\PantiProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function showDonatur()
    {
        $user = Auth::user();
        $profile = $user->donaturProfile;
        return view('profil.donatur', compact('user', 'profile'));
    }

    public function updateDonatur(Request $request)
    {
        $user = Auth::user();
        $profile = $user->donaturProfile;

        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($profile->photo_path) {
                Storage::delete($profile->photo_path);
            }
            $path = $request->file('photo')->store('profile_photos', 'public');
            $profile->photo_path = $path;
        }

        if (isset($validated['name'])) {
            $user->name = $validated['name'];
            $user->save();
        }

        if (isset($validated['phone'])) {
            $profile->phone = $validated['phone'];
        }
        if (isset($validated['address'])) {
            $profile->address = $validated['address'];
        }
        $profile->save();

        return back();
    }

    public function showPanti()
    {
        $user = Auth::user();
        $profile = $user->pantiProfile;
        return view('profil.panti', compact('user', 'profile'));
    }

    public function updatePanti(Request $request)
    {
        $user = Auth::user();
        $profile = $user->pantiProfile;

        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'head_name' => 'nullable|string|max:255',
            'nib_number' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($profile->photo_path) {
                Storage::delete($profile->photo_path);
            }
            $path = $request->file('photo')->store('profile_photos', 'public');
            $profile->photo_path = $path;
        }

        if (isset($validated['name'])) {
            $user->name = $validated['name'];
            $user->save();
        }

        if (isset($validated['phone'])) {
            $profile->phone = $validated['phone'];
        }
        if (isset($validated['address'])) {
            $profile->address = $validated['address'];
        }
        if (isset($validated['head_name'])) {
            $profile->head_name = $validated['head_name'];
        }
        if (isset($validated['nib_number'])) {
            $profile->nib_number = $validated['nib_number'];
        }
        $profile->save();

        return back();
    }
}
