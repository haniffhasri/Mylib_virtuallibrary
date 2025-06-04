@extends('layouts.backend')

@section('content')
    <div class="container">
        <h4>Edit Support Content</h4>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('support.update', $content) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="support_title" class="form-label">Title</label>
                <input name="support_title" id="support_title" class="form-control" value="{{ old('support_title', $content->support_title) }}" required>
            </div>

            <div class="mb-3">
                <label for="support_type" class="form-label">Type</label>
                <select name="support_type" id="support_type" class="form-select" required>
                    <option value="faq" {{ old('support_type', $content->support_type) === 'faq' ? 'selected' : '' }}>FAQ</option>
                    <option value="embedded_video" {{ old('support_type', $content->support_type) === 'embedded_video' ? 'selected' : '' }}>Embedded Video</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea name="content" id="content" class="form-control" rows="5">{{ old('content', $content->content) }}</textarea>
            </div>

            <button class="btn btn-success" type="submit">Update</button>
        </form>
    </div>
@endsection
