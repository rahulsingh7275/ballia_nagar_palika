<?php

namespace App\Http\Controllers;

use App\Models\PropertyTaxBill;
use Illuminate\Http\Request;

class PropertyTaxController extends Controller
{
    /**
     * Upload Form
     */
    public function uploadForm()
    {
        return view('property-tax.upload');
    }

    /**
     * Import CSV
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        $file = fopen(
            $request->file('file')->getRealPath(),
            'r'
        );

        $headers = fgetcsv($file);

        $headers = array_map(function ($header) {
            return trim(
                str_replace("\xEF\xBB\xBF", '', $header)
            );
        }, $headers);

        while (($row = fgetcsv($file)) !== false) {

            if (count($headers) != count($row)) {
                continue;
            }

            $data = array_combine($headers, $row);

            PropertyTaxBill::create($data);
        }

        fclose($file);

        return redirect()
            ->route('admin.property-tax.list')
            ->with('success', 'Data Imported Successfully');
    }

    /**
     * Bills List
     */
    public function bills()
    {
        $records = PropertyTaxBill::paginate(20);

        return view(
            'property-tax.bills',
            compact('records')
        );
    }

    /**
     * Single Bill View
     */
    public function show($id)
    {
        $row = PropertyTaxBill::findOrFail($id);

        return view(
            'property-tax.property-tax-bill',
            compact('row')
        );
    }
}