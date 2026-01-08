<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        $role = $request->query('role');
        
        $users = User::when($role, fn($q) => $q->where('role', $role))
            ->orderBy('role')
            ->orderBy('name')
            ->get();
        
        return view('admin.users.index', compact('users', 'role'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $program = Program::getDefault();
        
        return view('admin.users.create', compact('program'));
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => 'required|in:admin,kaprodi,dosen',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        
        // Auto-assign program_id for dosen and kaprodi
        if (in_array($validated['role'], ['dosen', 'kaprodi'])) {
            $validated['program_id'] = Program::getDefaultId();
        }

        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $user->load('courses');
        
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $program = Program::getDefault();
        
        return view('admin.users.edit', compact('user', 'program'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'role' => 'required|in:admin,kaprodi,dosen',
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }
        
        // Auto-assign program_id for dosen and kaprodi
        if (in_array($validated['role'], ['dosen', 'kaprodi'])) {
            $validated['program_id'] = Program::getDefaultId();
        } else {
            $validated['program_id'] = null;
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user)
    {
        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'Anda tidak dapat menghapus akun sendiri.']);
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}
