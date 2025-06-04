<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LibrarianValidationCode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LibrarianValidationCodeController extends Controller
{
    public function index()
    {
        $codes = LibrarianValidationCode::latest()->get();
        return view('admin.codes.index', compact('codes'));
    }

    public function store(Request $request)
    {
        $count = $request->input('count', 1);
        for ($i = 0; $i < $count; $i++) {
            LibrarianValidationCode::create([
                'code' => strtoupper(Str::random(10)),
            ]);
        }

        return redirect()->back()->with('success', 'Validation code(s) generated.');
    }

    public function destroy($id)
    {
        LibrarianValidationCode::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Validation code deleted.');
    }
}
