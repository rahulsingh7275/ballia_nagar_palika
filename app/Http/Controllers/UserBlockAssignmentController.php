<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\BlockUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserBlockAssignmentController extends Controller
{
    public function index(Request $request)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        if (! Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }

        $users = User::where('role_id', '!=', 1)->orderBy('name')->get();
        $blocks = Block::orderBy('name')->get();
        $assignments = BlockUser::with(['user', 'block'])
            ->orderBy('user_id')
            ->orderBy('block_id')
            ->get();

        $selectedUserId = old('user_id', $request->get('user_id'));
        $selectedBlockIds = old('block_ids', []);

        if (! empty($selectedUserId) && empty($selectedBlockIds)) {
            $selectedUser = User::find($selectedUserId);
            $selectedBlockIds = $selectedUser?->blocks()->pluck('blocks.id')->all() ?? [];
        }

        $userBlocks = [];
        foreach ($users as $user) {
            $userBlocks[$user->id] = $user->blocks()->pluck('blocks.id')->all();
        }

        return view('admin.user-block-assignments.index', compact(
            'users',
            'blocks',
            'assignments',
            'selectedUserId',
            'selectedBlockIds',
            'userBlocks'
        ));
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
            'user_id' => ['required', 'exists:users,id'],
            'block_ids' => ['required', 'array'],
            'block_ids.*' => ['integer', 'exists:blocks,id'],
        ]);

        $user = User::findOrFail($validated['user_id']);
        $user->blocks()->sync($validated['block_ids']);

        return back()->with('status', 'Blocks assigned successfully.');
    }
}
