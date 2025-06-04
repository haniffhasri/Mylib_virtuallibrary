@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Landing Page</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="keywords" />
    <meta name="description" content="NY Fee Bundle" />
    <meta name="robots" content="index,follow" />
  </head>

  <body>
    <style>
      body {
        color: #494b37;
        background-color: #fbfdf1;
        overflow-x: hidden;
      }

      body p {
        font-family: 'Avenir', sans-serif;
        color: #494b37;
      }
    </style>
    <link rel="stylesheet" />
    <div class="hero__wrapper">
      <div class="hero-top-container text-center">
        <img class="title-img element-fade-up" src="/image/logo-removebg-preview.png" alt="" />
      </div>
    </div>

    <!-- Section 1 -->
    <div class="gh-section first">
      <div class="top-content">
        <h4 class="element-fade-up">📚 Explore Featured Books in Our</h4>
        <h3 class="element-fade-up">Book List</h3>
        <p class="py-3 element-fade-up">Discover our newest additions, trending favorites, and timeless classics.</p>
      </div>
      <div class="carousel-holder">
        <div class="looping-carousel">
          @foreach ($books as $book)
          <div class="carousel-item">
            <img src="{{ asset('image/' . $book->image_path) }}" alt="{{ $book->book_title }}">
            <div class="front-img">
              <div class="desc">
                <img src="{{ asset('image/' . $book->image_path) }}" alt="{{ $book->book_title }}">
                <span>{{ $book->book_title }}</span>
                <h5><span>by {{ $book->author }}</span></h5>
                <a href="{{ route('book.show', $book->id) }}" class="btn btn-sm btn-primary">View Details</a>
              </div>
            </div>
        </div>
          @endforeach
        </div>
        <!-- Loopinhgg Carousel Clone -->
        <div class="looping-carousel">
          <!-- Carousel Item -->
          @foreach ($books as $book)
            <div class="carousel-item">
                <img src="{{ asset('image/' . $book->image_path) }}" alt="{{ $book->book_title }}">
                <div class="front-img">
                  <div class="desc">
                    <img src="{{ asset('image/' . $book->image_path) }}" alt="{{ $book->book_title }}">
                    <span>{{ $book->book_title }}</span>
                    <h5><span>by {{ $book->author }}</span></h5>
                    <a href="{{ route('book.show', $book->id) }}" class="btn btn-sm btn-primary">View Details</a>
                  </div>
                </div>
            </div>
          @endforeach
        </div>
      </div>
      <div class="carousel-bottom-desc">
        <a href="{{ route('book.index') }}" class="button center">See more of our books</a>
      </div>
    </div>
    <!-- Section 3 -->
    <div class="gh-section third">
      <div class="top-content">
        <h4>📚 Join the Conversation in Our</h4>
        <h3>Library Forum</h3>
        <p class="py-3">Have thoughts on a book? Looking for recommendations? Want to connect with other readers?
          Our <em>Library Forum</em> is the perfect place to ask questions, share insights, and explore discussions with fellow book lovers.</p>
        <a href="{{ route('forum.index') }}" class="button center my-7">Check Out Our Forum</a>
      </div>
    </div>

    <!-- Section 7 -->
    <div class="gh-section seventh">
      <h3 class="text-center">FAQ</h3>
      <br />
      <div class="accordion">
        @forelse ($faqs as $faq)
            <div class="accordion-item">
                <div class="accordion-header">
                    <p><b>{{ $faq->support_title }}</b></p>
                </div>
                <div class="accordion-content">
                    <p>{{ $faq->content }}</p>
                </div>
            </div>
        @empty
            <p>No FAQs available.</p>
        @endforelse
    </div>
    </div>

    <!-- Section 9 -->
    <div class="gh-section ninth">
      <div class="section-inner">
        <div class="column-desc">
          <div class="column-inner-desc">
            <h4>Let’s Keep the Pages Turning!</h4>
            <h3>Join Us Now</h3>
            {{-- <h4><b>Join Us Now</b></h4> --}}
            <span><a href="{{ route('register') }}" class="button">Register</b></a><p style="font-size: 80%;">*Already a Member? <a href="{{ route('login') }}">Sign In.</a></p></span>
          </div>
        </div>
        <div class="column-img">
          <div class="image-frame">
            <img src="/image/man-people-reading-a-book-vector.png" alt="" />
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
 
@endsection
