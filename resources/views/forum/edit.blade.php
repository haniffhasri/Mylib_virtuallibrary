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
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Forum</h2>

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                <div class="font-bold">Please fix the following errors:</div>
                <ul class="list-disc list-inside mt-2">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('forum.update', $forum->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="forum_title" class="block text-sm font-medium text-gray-700 mb-2">Forum Title</label>
                <input type="text" name="forum_title" id="forum_title" 
                       value="{{ old('forum_title', $forum->forum_title) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                       required>
            </div>

            <div class="mb-6">
                <label for="forum_description" class="block text-sm font-medium text-gray-700 mb-2">Forum Description</label>
                <textarea name="forum_description" id="forum_description" rows="5"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('forum_description', $forum->forum_description) }}</textarea>
            </div>

            <div class="flex items-center justify-end space-x-3">
                <a href="{{ route('forum.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Update Forum
                </button>
            </div>
        </form>
    </div>
</div>
@endsection