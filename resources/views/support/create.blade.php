@extends('layouts.backend')

@section('content')
    <div class="container">
        <h1>Add Support Content</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.support.store') }}">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input name="title" id="title" class="form-control" value="{{ old('title') }}" required>
            </div>

            <div class="mb-3">
                <label for="support_type" class="form-label">Type</label>
                <select name="support_type" id="support_type" class="form-select" required>
                    <option value="faq" {{ old('support_type') === 'faq' ? 'selected' : '' }}>FAQ</option>
                    <option value="embedded_video" {{ old('support_type') === 'embedded_video' ? 'selected' : '' }}>Embedded Video</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea name="content" id="content" class="form-control" rows="5" placeholder="FAQ answer or video embed code (e.g. iframe)">{{ old('content') }}</textarea>
            </div>

            <button class="btn btn-success" type="submit">Save</button>
        </form>
    </div>
@endsection
