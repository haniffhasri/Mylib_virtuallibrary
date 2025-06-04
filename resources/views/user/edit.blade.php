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
<div class="card p-4"> 
    <form action="{{ route('user.update', $users->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')
    
        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
        <div class="sm:col-span-4">
          <label for="username" class="block text-sm/6 font-medium text-gray-900">Name</label>
          <div class="mt-2">
            <div class="flex items-center rounded-md bg-white outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
              {{-- <div class="shrink-0 text-base text-gray-500 select-none sm:text-sm/6">workcation.com/</div> --}}
              <input type="text" name="name" value="{{ $users->name }}" class="block min-w-0 grow py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6">
            </div>
          </div>
        </div>

        <div class="sm:col-span-4">
          <label for="email" class="block text-sm/6 font-medium text-gray-900">Email address</label>
          <div class="mt-2">
            <input type="email" name="email" value="{{ $users->email }}" autocomplete="email" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" disabled>
          </div>
        </div>

        <div class="col-span-full">
          <label for="about" class="block text-sm/6 font-medium text-gray-900">Bio</label>
          <div class="mt-2">
            <textarea name="bio" value="{{ $users->bio }}"rows="3" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">{{ $users->bio }}</textarea>
          </div>
        </div>

        <div class="col-span-full">
          <label for="photo" class="block text-sm/6 font-medium text-gray-900">Photo</label>
          <div class="mt-2 flex items-center gap-x-3">
            <svg class="size-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon">
                @if ($users->profile_picture)
                    <img src="{{ asset('profile_picture/' . $users->profile_picture) }}" width="100">
                @else
                    <img src="{{ asset('profile_picture/default.jpg') }}" width="100">
                @endif
            </svg>
            <input type="file" name="profile_picture">
          </div>
        </div>

        {{-- <div class="col-span-full">
          <label for="photo" class="block text-sm/6 font-medium text-gray-900">Cover Photo</label>
          <div class="mt-2 flex items-center gap-x-3">
            <svg class="size-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon">
                @if ($users->cover_photo)
                    <img src="{{ asset('profile_picture/' . $users->cover_photo) }}" width="100">
                @endif
            </svg>
            <input type="file" name="cover_photo">
          </div>
        </div> --}}

        {{-- <div class="col-span-full">
          <label for="cover-photo" class="block text-sm/6 font-medium text-gray-900">Cover photo</label>
          <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
            <div class="text-center">
              <svg class="mx-auto size-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon">
                <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z" clip-rule="evenodd" />
              </svg>
              <div class="mt-4 flex text-sm/6 text-gray-600 items-center">
                <label for="cover_photo" class="h-min relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 focus-within:outline-hidden hover:text-indigo-500">
                    <input id="cover_photo" name="cover_photo" type="file">
                </label>
                <p class="pl-1">or drag and drop</p>
              </div>
              <p class="text-xs/5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
            </div>
          </div>
        </div> --}}
      </div>
        
      <div class="mt-6 flex items-center justify-end gap-x-6">
        <a href="{{ route('dashboard') }}" class="text-sm/6 font-semibold text-gray-900">
            Cancel
        </a>
        <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
      </div>
    </form>    
</div>
@endsection