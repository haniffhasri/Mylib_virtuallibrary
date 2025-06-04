<?php

// app/Http/Controllers/SupportController.php

namespace App\Http\Controllers;

use App\Models\Support;
use Illuminate\Http\Request;
class SupportController extends Controller
{
    // User-facing: Show support page
    public function index()
    {
        $faqs = Support::where('support_type', 'faq')->get();
        $videos = Support::where('support_type', 'embedded_video')->get();
        $contents = Support::latest()->paginate(10);

        return view('support.index', compact('faqs', 'videos', 'contents'));
    }

    public function create()
    {
        return view('support.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'support_title' => 'required',
            'support_type' => 'required|in:faq,embedded_video',
            'content' => 'nullable|string',
        ]);

        Support::create($request->all());

        return redirect()->route('support.index')->with('success', 'Support content added.');
    }

    public function destroy(Support $content)
    {
        $content->delete();

        return back()->with('success', 'Support content deleted.');
    }

    public function edit(Support $content)
    {
        return view('support.edit', compact('content'));
    }

    public function update(Request $request, Support $content)
    {
        $request->validate([
            'support_title' => 'required',
            'support_type' => 'required|in:faq,embedded_video',
            'content' => 'nullable|string',
        ]);

        $content->update($request->all());

        return redirect()->route('support.index')->with('success', 'Support content updated.');
    }
}
