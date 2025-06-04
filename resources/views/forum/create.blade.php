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
    <div class="{{ Auth::user()->usertype === 'admin' || Auth::user()->usertype === 'librarian' ? '' : 'container-fluid card p-5 w-fit' }}">
        <div class="mb-5">
            <h4 class="h3 d-inline align-middle">Create New Forum</h4>
        </div>  
        <div class="row">
            <div>
                <form class="max-w-sm" method="POST" action="{{ route('forum.store') }}"  enctype="multipart/form-data">
                    @csrf
                    <div class="mb-5">
                        <label for="forum_title" class="block mb-2 font-medium text-gray-900">Forum Name</label>
                        <input type="text" id="forum_title" name="forum_title" class="form-control" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                    </div>
                    <div class="mb-5">
                        <label for="forum_description" class="block mb-2 font-medium text-gray-900">Forum Description</label>
                        <textarea row="5" id="forum_description" name="forum_description" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-40 dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                    </div>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" id="submitBtn">Submit</button>
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                    @endif
                </form>
            </div>
        </div>
    </div>    
@endsection