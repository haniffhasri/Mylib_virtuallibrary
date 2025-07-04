@extends('layouts.backend')

@section('content')  
<div class="flex justify-center gap-3 bg-white shadow-xl items-center p-3">
    <form action="{{ route('admin.user.search') }}" method="GET" class="mb-0 w-full h-min">
        <div class="flex">
            <label for="search-dropdown" class="sr-only">Search</label>
            <div class="relative w-full">
                <input type="text" name="q" placeholder="Search users..." value="{{ request('q') }}" id="search-dropdown"
                    class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 border-s-gray-50 border-s-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:border-s-gray-700  dark:border-gray-600 dark:placeholder-gray-40 dark:focus:border-blue-500" />
                <button type="submit"
                        class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-blue-700 border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg class="w-4 h-4" aria-hidden="true" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                    <span class="sr-only">Search</span>
                </button>
            </div>
        </div>
    </form>
    <div class="accordion block h-min w-full p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 border-s-gray-50 border-s-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:border-s-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500">
        <div class="accordion-header">
            <p style="font-size: inherit; font-family: inherit; color: #9ca3af;">Filter</p>
        </div>
        <div class="accordion-content">
            <form action="{{ route('admin.user.search') }}" method="GET" class="max-w-lg mx-auto space-y-2">
                <input type="hidden" name="q" value="{{ request('q') }}">
                <select name="usertype" class="w-full p-2 border rounded">
                    <option value="">User Type</option>
                    <option value="admin" {{ request('usertype') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="librarian" {{ request('usertype') == 'librarian' ? 'selected' : '' }}>Librarian</option>
                    <option value="user" {{ request('usertype') == 'user' ? 'selected' : '' }}>User</option>
                </select>
                <input type="hidden" name="q" value="{{ request('q') }}">
                <select name="is_active" class="w-full p-2 border rounded">
                    <option value="">Status</option>
                    <option value="true" {{ request('is_active') === 'true' ? 'selected' : '' }}>Active</option>
                    <option value="false" {{ request('is_active') === 'false' ? 'selected' : '' }}>Deactivated</option>
                </select>
                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Filter
                </button>
            </form>
        </div>
    </div>
</div>
<form method="GET" action="{{ route('admin.user') }}" class="mb-4 mt-4 flex justify-end">
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
                <a href="{{ route('admin.user', ['sort' => 'latest']) }}"
                    class="block px-4 py-2 text-sm {{ request('sort') === 'latest' ? 'bg-gray-100 text-gray-900' : 'text-gray-700' }}"
                    role="menuitem">
                    Latest
                </a>
                <a href="{{ route('admin.user', ['sort' => 'oldest']) }}"
                    class="block px-4 py-2 text-sm {{ request('sort') === 'oldest' ? 'bg-gray-100 text-gray-900' : 'text-gray-700' }}"
                    role="menuitem">
                    Oldest
                </a>
            </div>
        </div>
    </div>
</form>
<div class="mb-3">
    <h4 class="h3 d-inline align-middle">List of Users</h4>
</div>
<!-- Users Table -->
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
                            Role
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
                    @foreach ($users as $singleUser)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $singleUser->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $singleUser->email }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if (Auth::user()->usertype == 'admin')
                                <form action="{{ route('user.updateRole', $singleUser->id) }}" method="POST" class="flex items-center">
                                    @csrf
                                    @method('PUT')
                                    <select name="usertype" onchange="confirmWithSwal(this)" 
                                            class="text-sm border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500">
                                        <option value="admin" {{ $singleUser->usertype == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="librarian" {{ $singleUser->usertype == 'librarian' ? 'selected' : '' }}>Librarian</option>
                                        <option value="user" {{ $singleUser->usertype == 'user' ? 'selected' : '' }}>User</option>
                                    </select>
                                </form>
                            @else
                                {{ ucfirst($singleUser->usertype) }}
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($singleUser->is_active === true)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Active
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    Deactivated
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <form action="{{ route('user.delete', $singleUser->id) }}" method="POST" class="show-confirm">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 transition duration-200">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // SweetAlert confirmation for role changes
    function confirmWithSwal(selectElement) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to change this user's role?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, change it!'
        }).then((result) => {
            if (result.isConfirmed) {
                selectElement.form.submit();
            } else {
                // Reset to original value
                selectElement.value = "{{ $singleUser->usertype }}";
            }
        });
    }
</script>
@endpush