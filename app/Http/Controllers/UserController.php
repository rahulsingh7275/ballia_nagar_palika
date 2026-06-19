<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        if (! Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }

        $users = User::with('role')->orderBy('name')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        if (! Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }

        $roles = Role::where('name','!=','admin')->orderBy('label')->get();
        $blocks = Block::orderBy('name')->get();

        return view('admin.users.create', compact('roles', 'blocks'));
    }

    public function store(Request $request)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        if (! Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'role_id' => ['required', 'exists:roles,id'],
            'block_ids' => ['nullable', 'array'],
            'block_ids.*' => ['integer', 'exists:blocks,id'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $validated['role_id'],
        ]);

        $user->blocks()->sync($validated['block_ids'] ?? []);

        return redirect()->route('admin.users.index')->with('status', 'User created successfully.');
    }

    public function edit(User $user)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        if (! Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }

        $roles = Role::orderBy('label')->get();
        $blocks = Block::orderBy('name')->get();

        return view('admin.users.edit', compact('user', 'roles', 'blocks'));
    }

    public function update(Request $request, User $user)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        if (! Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', 'min:8'],
            'role_id' => ['required', 'exists:roles,id'],
            'block_ids' => ['nullable', 'array'],
            'block_ids.*' => ['integer', 'exists:blocks,id'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role_id = $validated['role_id'];

        if ($validated['password']) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();
        $user->blocks()->sync($validated['block_ids'] ?? []);

        return redirect()->route('admin.users.index')->with('status', 'User updated successfully.');
    }

    public function assignBlocks(User $user)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        if (! Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }

        $blocks = Block::orderBy('name')->get();

        return view('admin.users.assign-blocks', compact('user', 'blocks'));
    }

    public function storeBlocks(Request $request, User $user)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        if (! Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }

        $validated = $request->validate([
            'block_ids' => ['nullable', 'array'],
            'block_ids.*' => ['integer', 'exists:blocks,id'],
        ]);

        $user->blocks()->sync($validated['block_ids'] ?? []);

        return redirect()->route('admin.users.assign-blocks', $user)
            ->with('status', 'Blocks assigned successfully.');
    }

    public function destroy(User $user)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        if (! Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }

        // Prevent deletion of own user
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('status', 'User deleted successfully.');
    }
}
