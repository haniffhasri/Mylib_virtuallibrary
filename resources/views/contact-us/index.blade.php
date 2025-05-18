@extends('layouts.backend')

@section('content')
    <div class="container-fluid p-0">
        <div class="mb-3">
            <h4 class="h3 d-inline align-middle">Insert Contact Information</h4>
        </div>  
        <div class="row">
            <div class="col-12 col-lg-6">
                <form class="max-w-sm" method="POST" action="{{ route('contact.store') }}"  enctype="multipart/form-data">
                    @csrf
                    <div class="mb-5">
                        <label for="email" class="block mb-2 font-medium text-gray-900">Email</label>
                        <input type="text" id="email" name="email" class="form-control" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                    </div>
                    <div class="mb-5">
                        <label for="contact" class="block mb-2 font-medium text-gray-900">Contact Number</label>
                        <input type="text" id="contact" name="contact" class="form-control" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
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