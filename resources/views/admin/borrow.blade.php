@extends('layouts.backend')

@section('content')
    <div class="mb-3">
        <h4 class="h3 d-inline align-middle">List of Borrowers</h4>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
                    @if ($borrows->is_active === true)
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
                                <form action="{{ route('borrow.delete', $borrows->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@endsection