<?php

namespace App\Http\Controllers;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function show($id) {
        $contact = Contact::findOrFail($id);
        return view('contact-us.show', compact('contact'));
    }

    public function update($id, Request $request){
        // Validate input fields
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'contact' => 'required|string|max:20',
        ]);

        // Fetch and update contact info
        $contact = Contact::findOrFail($id);
        $contact->email = $validated['email'];
        $contact->contact = $validated['contact'];
        $contact->save();

        return redirect()
            ->route('contact-us.show', $contact->id)
            ->with('success', 'Contact updated successfully.');
    }
}
