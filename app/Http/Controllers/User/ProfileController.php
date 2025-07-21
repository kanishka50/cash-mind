<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ProfileUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the user's profile.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('user.profile.edit', compact('user'));
    }

    /**
     * Update the user's profile.
     */
    public function update(ProfileUpdateRequest $request)
    {
        $user = Auth::user();
        $validated = $request->validated();

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $validated['profile_picture'] = $path;
        }

        // Only update password if provided
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        User::find(Auth::id())->update($validated);

        return redirect()->route('user.profile.edit')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Delete the user's profile picture.
     */
    public function deleteProfilePicture()
    {
        $user = Auth::user();

        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
            User::find(Auth::id())->update(['profile_picture' => null]);
        }

        return redirect()->route('user.profile.edit')
            ->with('success', 'Profile picture removed successfully.');
    }


    /**
 * Update the user's profile picture.
 */
public function updatePicture(Request $request)
{
    $request->validate([
        'profile_picture' => 'required|image|max:1024',
    ]);

    $user = Auth::user();

    // Delete old profile picture if exists
    if ($user->profile_picture) {
        Storage::disk('public')->delete($user->profile_picture);
    }
    
    // Store new profile picture
    $path = $request->file('profile_picture')->store('profile-pictures', 'public');
    User::find(Auth::id())->update(['profile_picture' => $path]);

    return redirect()->route('user.profile.edit')
        ->with('success', 'Profile picture updated successfully.');
}
}