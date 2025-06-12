@extends('layouts.backend')

@section('content')
<div class="container">
    <div class="flex items-center">
        <h4>Manage Librarian Validation Codes</h4>
        <x-help-icon-blade>
            After a librarian have been hired, you have to give them this code. It can only be used once.
        </x-help-icon-blade>
    </div>

    @if(session('success'))
        <div class="alert alert-success mt-2">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.codes.store') }}" class="mb-4">
        @csrf
        <div class="form-group">
            <label>How many codes to generate?</label>
            <input type="number" name="count" class="form-control w-25" value="1" min="1" required>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Generate</button>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Code</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($codes as $code)
                <tr>
                    <td>{{ $code->code }}</td>
                    <td>{{ $code->used ? 'Used' : 'Unused' }}</td>
                    <td>{{ $code->created_at->format('Y-m-d H:i') }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.codes.destroy', $code->id) }}">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm show-confirm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
