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
@if(Auth::user()->usertype === 'admin')
    <div class="container">
        <h1>Manage Support Content</h1>
        <a href="{{ route('support.create') }}" class="btn btn-primary mb-3">Add New Support Content</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($contents as $content)
                    <tr>
                        <td>{{ $content->title }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $content->support_type)) }}</td>
                        <td>
                            <form method="POST" action="{{ route('support.destroy', $content) }}" onsubmit="return confirm('Are you sure?')">
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
    <div class="container">
        <h1>Frequently Asked Questions</h1>
        @forelse ($faqs as $faq)
            <div class="mb-4">
                <h4>{{ $faq->title }}</h4>
                <p>{{ $faq->content }}</p>
            </div>
        @empty
            <p>No FAQs available.</p>
        @endforelse

        <h1 class="mt-5">Tutorial Videos</h1>
        @forelse ($videos as $video)
            <div class="mb-4">
                <h4>{{ $video->title }}</h4>
                <div>{!! $video->content !!}</div> {{-- Embedded iframe or video tag --}}
            </div>
        @empty
            <p>No tutorial videos available.</p>
        @endforelse
    </div>
@endif
@endsection
