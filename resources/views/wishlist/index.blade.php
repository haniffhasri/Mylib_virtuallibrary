@extends('layouts.backend')

@section('content')
<div class="mb-3">
    <h4 class="h3 d-inline align-middle">User Wishlist</h4>
</div>
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-left rtl:text-right">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Title
                </th>
                <th scope="col" class="px-6 py-3">
                    Author
                </th>
                <th scope="col" class="px-6 py-3">
                    Publisher
                </th>
                <th scope="col" class="px-6 py-3">
                    ISBN
                </th>
                <th scope="col" class="px-6 py-3">
                    Description
                </th>
                <th scope="col" class="px-6 py-3">
                    User
                </th>
                <th scope="col" class="px-6 py-3">
                    <span class="sr-only">Drop</span>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($wishlists as $wish)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap">
                    {{ $wish->title }}
                </th>
                <td class="px-6 py-4">
                    {{ $wish->author ?? 'N/A' }}
                </td>
                <td class="px-6 py-4">
                    {{ $wish->publisher ?? 'N/A' }}
                </td>
                <td class="px-6 py-4">
                    {{ $wish->isbn ?? 'N/A' }}
                </td>
                <td class="px-6 py-4">
                    {{ $wish->description }}
                </td>
                <td class="px-6 py-4">
                    <small>Wished by {{ $wish->user->username }} on {{ $wish->created_at->format('d M Y') }}</small>
                </td>
                <td class="px-6 py-4 text-right">
                    <form action="{{ route('wishlist.delete', $wish->id) }}" method="POST" class="show-confirm">
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
<script>
    function confirmWithSwal(selectElement) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to change the user type?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, change it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                selectElement.form.submit();
            } else {
                selectElement.selectedIndex = 0;
            }
        });
    }
</script>
@endsection
