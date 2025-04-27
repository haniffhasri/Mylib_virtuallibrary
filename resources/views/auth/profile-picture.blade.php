@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Select Your Profile Picture') }}</div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <form id="profileForm" action="{{ route('profile.picture.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-6 mb-3">
                        <input type="file" name="profile_picture" accept="image/*" capture="environment" required>
                        </div>
                        <div class="row ">
                            <button type="submit" class="btn btn-primary">Upload</button>
                            <button type="button" id="skipButton" class="btn btn-secondary ms-2">Skip</button>
                        </div>
                        <input type="hidden" name="skip" id="skipInput" value="0">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // JavaScript for Skip button
    document.getElementById('skipButton').addEventListener('click', function() {
        document.getElementById('skipInput').value = '1'; // Set skip input
        document.getElementById('profileForm').submit();   // Submit form
    });
</script>
@endsection