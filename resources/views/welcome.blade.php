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
      *{
        margin: 0;
        padding: 0;
        font-family: poppins !important;
      }
      body {
        color: #494b37;
        background-color: #fbfdf1;
        overflow-x: hidden;
      }
      body * {
        font-family: 'Avenir', sans-serif;
      }
      .wrapper {
          display: grid;
          grid-template-columns: 50% auto;
          background-color: #fbfdf1;
      }
    </style>
    <link rel="stylesheet" />
    <div class="relative">
      <div class="overlay"></div>
      <div class="gh-section first">
        <div class="container">
          <div class="menu">
            <div class="logo">
              <a href="/" style="top: -2rem; position: relative;"><img class="title-img element-fade-up" src="/image/logo-removebg-preview.png" alt="" /></a>
            </div>
          </div>
          <div class="wrapper">
            <div class="l-wrap">
              <h1 class="elmt">The Future Of <span> Virtual Library</span> is way better than anything</h1>
              <p class="elmt">Read, Share, Connect — Where Readers Belong</p>
              <div class="button elmt">
                <a href="{{ route('book.index') }}">Read Now</a>
                <div class="vidBtn">
                  @if (!Auth::check())
                    <a class="normal-link" href="{{ route('login') }}"><p>Sign In</p></a>
                  @else
                    <a class="normal-link" href="{{ route('dashboard') }}"><p>Dashboard</p></a>
                  @endif
                </div>
              </div>
            </div>
            <div class="r-wrap">
              <div class="img-1">
                @foreach ($books->shuffle() as $book)
                  <a href="{{ route('book.show', $book->id) }}"><img src="{{ Storage::disk('s3')->url($book->image_path) }}" alt="{{ $book->book_title }}"></a>
                @endforeach
              </div>
              <div class="img-1">
                @foreach ($books->shuffle() as $book)
                  <a href="{{ route('book.show', $book->id) }}"><img src="{{ Storage::disk('s3')->url($book->image_path) }}" alt="{{ $book->book_title }}"></a>
                @endforeach
              </div>
              <div class="img-1">
                @foreach ($books->shuffle() as $book)
                  <a href="{{ route('book.show', $book->id) }}"><img src="{{ Storage::disk('s3')->url($book->image_path) }}" alt="{{ $book->book_title }}"></a>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Section 3 -->
    <div class="gh-section third">
      <div class="top-content">
        <h3>
          <span>Have thoughts on a book?</span><br />
          <span>Looking for recommendations?</span><br />
          <span>Want to connect with other readers?</span><br />
          <span>Join the conversation — from book reviews</span>
          <span>to hot takes, your voice matters here.</span>
        </h3>
        <a href="{{ route('forum.index') }}" class="button center my-7"><span>Check Out Our Forum</span></a>
      </div>
    </div>
    <!-- Section 7 -->
    <div class="gh-section seventh">
      <h3 class="text-center text-white font-bold italic">FAQ</h3>
      <br />
      <div class="flip-container">
        @forelse ($faqs as $faq)
          <div class="flip-card">
            <div class="flip-card-inner">
              <div class="flip-card-front">
                <p class="text-xl">{{ $faq->support_title }}</p>
              </div>
              <div class="flip-card-back">
                <p>{{ $faq->content }}</p>
              </div>
            </div>
          </div>
        @empty
          <p>No FAQs available.</p>
        @endforelse
      </div>
      <div class="inner">
        <a href="{{ route('support.index') }}" class="button center my-7"><span>See More</span></a>
      </div>
    </div>


    <!-- Section 9 -->
    <div class="gh-section ninth">
      <div class="section-inner">
        <div class="column-desc">
          <div class="column-inner-desc">
            <h4>Let’s Keep the Pages Turning!</h4>
            @if (!Auth::check())
              <h3>Join Us Now</h3>
            @else
             <h3>Go To Your Dashboard</h3>
            @endif
            <div class="inner">
              @if (!Auth::check())
                <a href="{{ route('register') }}">Register</a>
                <p class="text-xs">*Already a Member? <a href="{{ route('login') }}" class="normal-link" style="font-size: 0.75rem !important; padding-left: 0 !important;">Sign In.</a></p>
              @else
                <a href="{{ route('dashboard') }}">Dashboard</a>
              @endif
            </div>
            <!-- Contact Details -->
            <div class="contact-info">
              <p class="text-xs">For any inquiry or report, you can reach out here:</p>
              <p class="text-xs">Email: 
                <a href="mailto:{{ $contact->email }}">
                    {{ $contact->email }}
                </a>
              </p>
              <p class="text-xs">Contact: 
                <a href="tel:{{ $contact->contact }}">
                    {{ $contact->contact }}
                </a>
              </p>
            </div>
          </div>
        </div>

        <div class="column-img">
          <div class="image-frame">
            <img src="/image/man-people-reading-a-book-vector.png" alt="Reading Illustration" />
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
 <script>
  document.addEventListener('DOMContentLoaded', () => {
    const tl = gsap.timeline();

    // Entrance animations
    tl.from(".logo", 1, {
      y: 200,
      opacity: 0
    });
    tl.from(".elmt", 1, {
      y: 500,
      stagger: 0.2,
      opacity: 0
    });
    tl.from(".img-1 img", 1, {
      y: 500,
      scale: 1.4,
      stagger: 0.2,
      opacity: 0
    });
    tl.to(".img-1 img", 1, {
      y: "-=50",
      ease: "power1.inOut",
      stagger: 0.2
    });

    // Animate the overlay to cover the first section as we scroll to .third
    gsap.to(".overlay", {
      scale: 40, // Grow the circle to cover screen
      ease: "power2.inOut",
      scrollTrigger: {
        trigger: ".gh-section.first",
        start: "top top",
        endTrigger: ".gh-section.third",
        end: "top 20%",
        scrub: true,
        pin: true, // optional if you want freeze effect
        // markers: true
      }
    });

    gsap.fromTo(
      ".gh-section.third h3 span",
      {
        opacity: 0,
        y: 30
      },
      {
        opacity: 1,
        y: 0,
        stagger: 0.2,
        duration: 0.8,
        ease: "power2.out",
        scrollTrigger: {
          trigger: ".gh-section.third",
          start: "top 70%",
          end: "bottom 60%",
          scrub: true, 
      }
    });

    gsap.from(".gh-section.ninth .column-desc", {
      y: 80,
      opacity: 0,
      duration: 1.2,
      ease: "power3.out",
      scrollTrigger: {
        trigger: ".gh-section.ninth",
        start: "top 80%",
        toggleActions: "play none none reverse"
      }
    });

    gsap.from(".gh-section.ninth .column-img", {
      x: 100,
      opacity: 0,
      duration: 1,
      ease: "power2.out",
      scrollTrigger: {
        trigger: ".gh-section.ninth",
        start: "top 80%",
        toggleActions: "play none none reverse"
      }
    });
  });
 </script>
@endsection
