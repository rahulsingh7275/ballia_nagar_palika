<?php

namespace App\Http\Controllers;

use App\Models\Block;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlockController extends Controller
{
    public function index()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        if (! Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }

        $blocks = Block::orderBy('name')->get();

        return view('admin.blocks.index', compact('blocks'));
    }

    public function create()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        if (! Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }

        return view('admin.blocks.create');
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
            'name' => ['required', 'string', 'max:255', 'unique:blocks,name'],
        ]);

        Block::create($validated);

        return redirect()->route('admin.blocks.index')->with('status', 'Block created successfully.');
    }

    public function edit(Block $block)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        if (! Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }

        return view('admin.blocks.edit', compact('block'));
    }

    public function update(Request $request, Block $block)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        if (! Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:blocks,name,' . $block->id],
        ]);

        $block->update($validated);

        return redirect()->route('admin.blocks.index')->with('status', 'Block updated successfully.');
    }

    public function destroy(Block $block)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        if (! Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }

        $block->delete();

        return redirect()->route('admin.blocks.index')->with('status', 'Block deleted successfully.');
    }
}
