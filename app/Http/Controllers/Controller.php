<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Book;
use App\Models\Contact;
use App\Models\Support;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function landingPage(){
        $faqs = Support::where('support_type', 'faq')->take(6)->get(); 
        $books = Book::inRandomOrder()->take(30)->get();
        $contact = Contact::first();
        return view('welcome', compact('faqs', 'books', 'contact'));
    }
}