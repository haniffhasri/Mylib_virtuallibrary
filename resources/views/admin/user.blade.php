@extends('layouts.backend')

@section('content')  


<div class="mb-3">
    <h4 class="h3 d-inline align-middle">List of Users</h4>
</div>
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    User ID
                </th>
                <th scope="col" class="px-6 py-3">
                    User Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Email
                </th>
                <th scope="col" class="px-6 py-3">
                    Role
                </th>
                <th scope="col" class="px-6 py-3">
                    View
                </th>
                <th scope="col" class="px-6 py-3">
                    <span class="sr-only">Drop</span>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $singleUser)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                    {{ $singleUser->id }}
                </th>
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                    {{ $singleUser->name }}
                </th>
                <td class="px-6 py-4">
                    {{ $singleUser->email }}
                </td>
                <td class="px-6 py-4">
                    @if (Auth::user()->usertype == 'admin')
                        <form action="{{ route('user.updateRole', $singleUser->id) }}" method="POST" style="display: flex; align-items: center;">
                            @csrf
                            @method('PUT')
                            <select name="usertype" class="form-select form-select-sm me-2" onchange="this.form.submit()">
                                <option value="user" {{ $singleUser->usertype == 'user' ? 'selected' : '' }}>User</option>
                                <option value="librarian" {{ $singleUser->usertype == 'librarian' ? 'selected' : '' }}>Librarian</option>
                                <option value="admin" {{ $singleUser->usertype == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </form>
                    @else
                        {{ $singleUser->usertype }}
                    @endif
                </td>
                <td class="px-6 py-4 text-right">
                    <form action="{{ route('admin.view', $singleUser->id) }}" method="GET">
                        @csrf
                        <button type="submit" class="btn btn-primary">View</button>
                    </form>
                </td>
                <td class="px-6 py-4 text-right">
                    <form action="{{ route('user.delete', $singleUser->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection