<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Book;
use App\Models\Support;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function landingPage(){
        $faqs = Support::where('support_type', 'faq')->take(10)->get(); 
        $books = Book::latest()->take(10)->get();
        return view('welcome', compact('faqs', 'books'));
    }
}