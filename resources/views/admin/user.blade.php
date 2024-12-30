<x-admin_page>
    <table class="borrow-table">
        <tr>
            <th>User id</th>
            <th>User Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Drop</th>
        </tr>

        @foreach ($users as $singleUser)
            <tr>
                <td>{{ $singleUser->id }}</td>
                <td>{{ $singleUser->name }}</td>
                <td>{{ $singleUser->email }}</td>
                <td>{{ $singleUser->usertype }}</td>
                <td>
                    <form action="{{ route('user.delete', $singleUser->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form></td>
            </tr>
        @endforeach
    </table>
</x-admin_page>