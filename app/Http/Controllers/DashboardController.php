<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\District;
use App\Models\Index;
use App\Models\PropertyTaxBill;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $user = Auth::user();
        $selectedBlockId = $request->input('block_id');

        if ($user->isAdmin()) {
            $blocks = Block::orderBy('name')->get();
            $query = PropertyTaxBill::query();

            if ($selectedBlockId) {
                $query->where('block_id', $selectedBlockId);
            }
        } else {
            $blocks = $user->blocks()->orderBy('name')->get();
            $allowedBlockIds = $blocks->pluck('id')->all();
            $query = PropertyTaxBill::query();

            if (! empty($allowedBlockIds)) {
                $query->whereIn('block_id', $allowedBlockIds);

                if ($selectedBlockId && in_array((int) $selectedBlockId, $allowedBlockIds, true)) {
                    $query->where('block_id', (int) $selectedBlockId);
                } elseif ($selectedBlockId) {
                    $query->whereRaw('1 = 0');
                }
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        $houseTax = (float) $query->clone()->sum(DB::raw("COALESCE(CAST(house_tax_current_tax AS DECIMAL(15,2)), 0)"));
        $waterTax = (float) $query->clone()->sum(DB::raw("COALESCE(CAST(water_tax_current_tax AS DECIMAL(15,2)), 0)"));
        $sewerTax = (float) $query->clone()->sum(DB::raw("COALESCE(CAST(sewerage_tax_current_tax AS DECIMAL(15,2)), 0)"));
        $totalTax = $houseTax + $waterTax + $sewerTax;

        $summary = [
            'users' => User::count(),
            'house_tax' => $houseTax,
            'water_tax' => $waterTax,
            'sewer_tax' => $sewerTax,
            'total_tax' => $totalTax,
        ];

        return view('dashboard.index', compact('user', 'summary', 'blocks', 'selectedBlockId'));
    }

    public function assignedBlocksPage()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $user = Auth::user();
        $blocks = $user->blocks()->orderBy('name')->get();

        return view('dashboard.assigned-blocks', compact('user', 'blocks'));
    }
}
