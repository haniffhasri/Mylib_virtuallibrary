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
    <!-- Borrowers Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            User Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Book Title
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Due Date
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($borrow as $borrows)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $borrows->user->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $borrows->user->email }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $borrows->book->book_title }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $borrows->due_date }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($borrows->is_active === true)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Active
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    Removed
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            @if ($borrows->is_active === true)
                                <form action="{{ route('borrow.delete', $borrows->id) }}" method="POST" class="inline show-confirm">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 transition duration-200">
                                        Remove
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection