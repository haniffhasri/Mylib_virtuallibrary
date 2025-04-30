@extends('layouts.backend')

@section('content')    
<table class="borrow-table">
        <tr>
            <th>User Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Drop</th>
        </tr>

        @foreach ($users as $singleUser)
            <tr>
                <td>{{ $singleUser->name }}</td>
                <td>{{ $singleUser->email }}</td>
                <td>
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
                <td>
                    <form action="{{ route('user.delete', $singleUser->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form></td>
            </tr>
        @endforeach
    </table>
@endsection