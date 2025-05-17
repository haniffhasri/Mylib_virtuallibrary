@extends('layouts.backend')

@section('content')
<div class="container">
    <h2>Backup & Restore</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('backup.create') }}" method="POST">
        @csrf
        <button class="btn btn-primary">Create New Backup</button>
    </form>

    <hr>

    <h4>Available Backups</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Filename</th>
                <th>Download</th>
                <th>Restore</th>
            </tr>
        </thead>
        <tbody>
            @foreach($backups as $file)
                <tr>
                    <td>{{ basename($file) }}</td>
                    <td><a href="{{ route('backup.download', basename($file)) }}" class="btn btn-sm btn-info">Download</a></td>
                    <td>
                        <form action="{{ route('backup.restore', basename($file)) }}" method="POST" onsubmit="return confirm('Restore this backup?')">
                            @csrf
                            <button class="btn btn-sm btn-danger">Restore</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
