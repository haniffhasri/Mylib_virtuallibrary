@extends('layouts.backend')

@section('content')
<h1>This is ADMIN VIEW PAGE</h1>
    <h2>Viewing Dashboard of {{ $user->name }}</h2>
    <div class="profile-show">
        <p>User Name: {{ $user->name }}</p>
        <p>Email: {{ $user->email }}</p>
        <p>Bio: {{ $user->bio }}</p>
        <p>Joined: {{ $user->created_at }}</p>
        {{-- Any other admin-level actions --}}
    </div>
    <a href="{{ route('admin.user') }}" class="btn btn-secondary mt-3">← Back to User List</a>
@endsection
