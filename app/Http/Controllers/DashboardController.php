<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Index;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $user = Auth::user();
        $summary = [
            'users' => User::count(),
        ];

        return view('dashboard.index', compact('user', 'summary'));
    }
}
