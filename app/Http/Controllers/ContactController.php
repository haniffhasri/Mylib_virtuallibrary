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
        $contact = Contact::findOrFail($id);
        $contactid = $contact->id;
        $contact->email = $request->email;
        $contact->contact = $request->contact;

        $contact->save();

        return redirect()->route('contact-us.show', $contactid)->with('success', 'Contact updated');
    }
}
