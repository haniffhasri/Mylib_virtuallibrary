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
        <a href="{{ route('support.create') }}" class="mb-6 inline-block px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
            Add New Support Content
        </a>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-md">{{ session('success') }}</div>
        @endif

        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><b>Title</b></th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><b>Content</b></th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><b>Type</b></th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><b>Actions</b></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($contents as $content)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $content->support_title }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">{{ $content->content }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ ucfirst(str_replace('_', ' ', $content->support_type)) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-y-2">
                                <a href="{{ route('support.edit', $content) }}" class="block px-3 py-1 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition duration-200 text-center">Edit</a>
                                <form method="POST" action="{{ route('support.destroy', $content) }}" class="show-confirm">
                                    @csrf
                                    @method('DELETE')
                                    <button class="w-full px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 transition duration-200">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">No support content available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $contents->links() }}
        </div>
    </div>
@else
<div class="gh-section seventh support">
    <h4>Frequently Asked Questions</h4>
    <br />
    <div class="accordion" id="faq">
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
    <div class="container" id="tutorialvideos">
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
@endsection
