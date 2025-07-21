<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(Request $request)
    {
        $query = User::query();
        
        // Filter by admin status if requested
        if ($request->has('filter') && $request->filter === 'admin') {
            $query->where('is_admin', true);
        }
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        $users = $query->paginate(15)->withQueryString();
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
            'profile_picture' => 'nullable|image|max:1024',
            'is_admin' => 'nullable|boolean',
        ]);

        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $validated['profile_picture'] = $path;
        }

        // Hash the password
        $validated['password'] = Hash::make($validated['password']);

        // Set admin status
        $validated['is_admin'] = $request->has('is_admin') ? true : false;

        $user = User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        // Eager load the relationships to avoid N+1 queries
        $user->load(['userCourses', 'orders']);
        
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'profile_picture' => 'nullable|image|max:1024',
            'is_admin' => 'nullable|boolean',
        ]);

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

        // Set admin status
        $validated['is_admin'] = $request->has('is_admin') ? true : false;

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Cannot delete yourself
        if (User::find(Auth::id()) === $user->id) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        // Delete profile picture if exists
        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }


    /**
 * Update the user's profile picture.
 */
public function updatePicture(Request $request, User $user)
{
    $request->validate([
        'profile_picture' => 'required|image|max:1024',
    ]);

    // Delete old profile picture if exists
    if ($user->profile_picture) {
        Storage::disk('public')->delete($user->profile_picture);
    }
    
    // Store new profile picture
    $path = $request->file('profile_picture')->store('profile-pictures', 'public');
    $user->update(['profile_picture' => $path]);

    return redirect()->route('admin.users.edit', $user)
        ->with('success', 'Profile picture updated successfully.');
}

/**
 * Delete the user's profile picture.
 */
public function deletePicture(User $user)
{
    if ($user->profile_picture) {
        Storage::disk('public')->delete($user->profile_picture);
        $user->update(['profile_picture' => null]);
    }

    return redirect()->route('admin.users.edit', $user)
        ->with('success', 'Profile picture removed successfully.');
}



}