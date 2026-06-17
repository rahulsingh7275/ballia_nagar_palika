<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

abstract class Controller extends BaseController
{
    protected function guard()
    {
        return Auth::user();
    }

    protected function requireAuth(): RedirectResponse|null
    {
        if (! Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to continue.');
        }

        return null;
    }

    protected function authorizeRole(string $role): bool
    {
        return Auth::check() && Auth::user()->role?->name === $role;
    }
}
