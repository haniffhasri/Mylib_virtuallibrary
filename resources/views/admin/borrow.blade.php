@extends('layouts.backend')

@section('content')
    <form method="GET" action="{{ route('admin.borrow') }}" class="mb-4 mt-4 flex justify-end">
        <div x-data="{ open: false }" class="relative inline-block text-left">
            <div>
                <button @click="open = !open"
                    type="button"
                    class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 border-none shadow-lg ring-1 ring-gray-300 ring-inset hover:bg-gray-50"
                    id="menu-button"
                    aria-expanded="true"
                    aria-haspopup="true">
                    Sort by: {{ ucfirst(request('sort', 'latest')) }}
                    <svg class="-mr-1 size-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <div x-show="open" @click.away="open = false"
                x-transition
                class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none"
                role="menu"
                aria-orientation="vertical"
                aria-labelledby="menu-button"
                tabindex="-1">
                <div class="py-1" role="none">
                    <a href="{{ route('admin.borrow', ['sort' => 'latest']) }}"
                        class="block px-4 py-2 text-sm {{ request('sort') === 'latest' ? 'bg-gray-100 text-gray-900' : 'text-gray-700' }}"
                        role="menuitem">
                        Latest
                    </a>
                    <a href="{{ route('admin.borrow', ['sort' => 'oldest']) }}"
                        class="block px-4 py-2 text-sm {{ request('sort') === 'oldest' ? 'bg-gray-100 text-gray-900' : 'text-gray-700' }}"
                        role="menuitem">
                        Oldest
                    </a>
                </div>
            </div>
        </div>
    </form>
    <div class="mb-3">
        <h4 class="h3 d-inline align-middle">List of Borrowers</h4>
        <x-help-icon-blade>
            List of borrowed book by the user
        </x-help-icon-blade>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        User Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Email
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Book Title
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Due
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <span class="sr-only">Drop</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($borrow as $borrows)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            {{ $borrows->user->name }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $borrows->user->email }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $borrows->book->book_title }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $borrows->due_date }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if ($borrows->is_active === true)
                                <form action="{{ route('borrow.delete', $borrows->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection