@php
    if (Auth::check()) {
        $usertype = Auth::user()->usertype;
        $layout = ($usertype === 'admin' || $usertype === 'librarian') ? 'layouts.backend' : 'layouts.app';
    } else {
        $layout = 'layouts.app';
    }
@endphp

@extends($layout)

@section('content')
@if(Auth::check() && Auth::user()->usertype === 'admin') 
    <div class="container">
        <div class="flex items-center">
            <h4>Manage Support Content</h4>
            <x-help-icon-blade>
                You can add FAQs and a video guide by embedding the link of the video in the content
            </x-help-icon-blade>
        </div>
        <a href="{{ route('support.create') }}" class="btn btn-primary mb-3">Add New Support Content</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($contents as $content)
                    <tr>
                        <td>{{ $content->support_title }}</td>
                        <td>{{ $content->content }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $content->support_type)) }}</td>
                        <td><a href="{{ route('support.edit', $content) }}" class="btn btn-sm btn-warning w-full mb-1">Edit</a>
                            <form method="POST" action="{{ route('support.destroy', $content) }}" class="w-full show-confirm">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3">No support content available.</td></tr>
                @endforelse
            </tbody>
        </table>

        {{ $contents->links() }}
    </div>
@else
<div class="gh-section seventh">
    <h4>Frequently Asked Questions</h4>
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
    <div class="container">
        <h4 class="mt-5">Tutorial Videos</h4>
        @forelse ($videos as $video)
            <div class="mb-4">
                <p><b>{{ $video->support_title }}</b></p>
                <div>{!! $video->content !!}</div> {{-- Embedded iframe or video tag --}}
            </div>
        @empty
            <p>No tutorial videos available.</p>
        @endforelse
    </div>
</div>
@endif
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>
    if ($('div').is('.accordion')) {
        // Initially, hide all accordion content
        $('.accordion-content').hide();

        // When an accordion header is clicked
        $('.accordion-header').click(function () {
          // Toggle the content
          var content = $(this).next('.accordion-content');
          content.slideToggle(200);

          // Toggle the active class to change the style
          $(this).toggleClass('active');

          // Close other open accordions
          $('.accordion-content').not(content).slideUp(200);
          $('.accordion-header').not(this).removeClass('active');
        });
      }
</script>
@endsection
