<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\PropertyTaxBill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PropertyTaxController extends Controller
{
    private function normalizeImportValue(mixed $value): mixed
    {
        if ($value === null) {
            return null;
        }

        if (is_string($value)) {
            $trimmed = trim($value);

            if ($trimmed === '') {
                return null;
            }

            return $trimmed;
        }

        return $value;
    }

    /**
     * Upload Form
     */
    public function uploadForm()
    {
        $blocks = Block::orderBy('name')->get();

        return view('property-tax.upload', compact('blocks'));
    }

    /**
     * Import CSV
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,txt,xls,xlsx'],
            'block_id' => ['required', 'exists:blocks,id'],
        ]);

        $file = $request->file('file');
        $extension = strtolower($file->getClientOriginalExtension());
        $importedCount = 0;

        if (in_array($extension, ['csv', 'txt'], true)) {
            $handle = fopen($file->getRealPath(), 'r');

            if ($handle === false) {
                return back()->withErrors([
                    'file' => 'Unable to read the uploaded file.',
                ]);
            }

            $headers = fgetcsv($handle);
            $headers = array_map(function ($header) {
                return trim(
                    str_replace("\xEF\xBB\xBF", '', $header)
                );
            }, $headers);

            while (($row = fgetcsv($handle)) !== false) {
                if (! is_array($row) || count($headers) !== count($row)) {
                    continue;
                }

                $data = array_combine($headers, $row);

                if (! is_array($data)) {
                    continue;
                }

                $normalizedData = array_map([$this, 'normalizeImportValue'], $data);

                if (! empty(array_filter($normalizedData, fn ($value) => $value !== null))) {
                    PropertyTaxBill::create([
                        ...$normalizedData,
                        'block_id' => $request->input('block_id'),
                    ]);
                    $importedCount++;
                }
            }

            fclose($handle);
        } else {
            $spreadsheet = IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            if (empty($rows)) {
                return back()->withErrors([
                    'file' => 'The uploaded file is empty.',
                ]);
            }

            $headers = array_map(function ($header) {
                return trim((string) $header);
            }, array_shift($rows));

            foreach ($rows as $row) {
                if (count($headers) !== count($row)) {
                    continue;
                }

                $data = array_combine($headers, $row);

                if (! is_array($data)) {
                    continue;
                }

                $normalizedData = array_map([$this, 'normalizeImportValue'], $data);

                if (! empty(array_filter($normalizedData, fn ($value) => $value !== null))) {
                    PropertyTaxBill::create([
                        ...$normalizedData,
                        'block_id' => $request->input('block_id'),
                    ]);
                    $importedCount++;
                }
            }
        }

        return redirect()
            ->route('admin.property-tax.list', ['block_id' => $request->input('block_id')])
            ->with('success', 'Imported '.$importedCount.' record(s) successfully for the selected block.');
    }

    /**
     * Bills List
     */
    public function bills(Request $request)
    {
        $selectedBlockId = $request->input('block_id');
        $user = Auth::user();

        if ($user && $user->isAdmin()) {
            $blocks = Block::orderBy('name')->get();
            $query = PropertyTaxBill::query()->with('block');

            if ($selectedBlockId) {
                $query->where('block_id', $selectedBlockId);
            }
        } else {
            $blocks = $user
                ? $user->blocks()->orderBy('name')->get()
                : collect();

            $allowedBlockIds = $blocks->pluck('id')->all();
            $query = PropertyTaxBill::query()->with('block');

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

        $records = $query
            ->orderByDesc('id')
            ->paginate(20)
            ->appends($request->query());

        return view(
            'property-tax.bills',
            compact('records', 'blocks', 'selectedBlockId')
        );
    }

    /**
     * Single Bill View
     */
    public function show($id)
    {
        $row = PropertyTaxBill::with('block')->findOrFail($id);

        if (! Auth::user()?->isAdmin()) {
            $allowedBlockIds = Auth::user()
                ? Auth::user()->blocks()->pluck('blocks.id')->all()
                : [];

            if (! in_array($row->block_id, $allowedBlockIds, true)) {
                abort(403);
            }
        }

        return view(
            'property-tax.property-tax-bill',
            compact('row')
        );
    }
}