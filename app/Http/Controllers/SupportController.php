<?php

// app/Http/Controllers/SupportController.php

namespace App\Http\Controllers;

use App\Models\Support;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class SupportController extends Controller
{
    // User-facing: Show support page
    public function showSupportPage()
    {
        $faqs = Support::where('support_type', 'faq')->get();
        $videos = Support::where('support_type', 'embedded_video')->get();

        return view('support.index', compact('faqs', 'videos'));
    }

    // Admin-facing: Show create form
    public function create()
    {
        $this->authorizeAdmin();
        return view('admin.support.create');
    }

    // Admin-facing: Store new support content
    public function store(Request $request)
    {
        // $this->authorizeAdmin();

        $request->validate([
            'title' => 'required|string|max:255',
            'support_type' => 'required|in:faq,embedded_video',
            'content' => 'nullable|string',
        ]);

        Support::create($request->all());

        return redirect()->route('admin.support.index')->with('success', 'Support content added.');
    }

    // Admin-facing: Delete content
    public function destroy(Support $content)
    {
        // $this->authorizeAdmin();

        $content->delete();

        return back()->with('success', 'Support content deleted.');
    }
}
