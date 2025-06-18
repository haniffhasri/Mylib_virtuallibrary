@extends('layouts.backend')

@section('content')
<div class="container">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center">
            <h4>Backup</h4>
            <x-help-icon-blade>
                This is the backup page. The system will automatically backup itself. You just have to download the file.
            </x-help-icon-blade>
        </div>
        <button id="createBackupBtn" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
            Create Backup
        </button>
    </div>

    @if(session('output'))
    <div class="mt-3 alert alert-info">
        <pre>{{ session('output') }}</pre>
    </div>
    @endif

    <!-- Divider -->
    <hr class="border-gray-200">

    <!-- Backup Files Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            File Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Size
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Created At
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($backupFiles as $file)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ basename($file) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ formatBytes($backupDisk->size($file)) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ date('Y-m-d H:i:s', $backupDisk->lastModified($file)) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                            <a href="{{ route('backup.download', ['file' => basename($file)]) }}" 
                               class="text-blue-600 hover:text-blue-900">
                                Download
                            </a>
                            <form action="{{ route('backup.delete', ['file' => basename($file)]) }}" 
                                  method="POST" class="inline show-confirm">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 transition duration-200">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                            No backup files found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@push('scripts')
<script>
    document.getElementById('createBackupBtn').addEventListener('click', function() {
        this.disabled = true;
        this.textContent = 'Creating Backup...';
        
        fetch('{{ route("backup.create") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Backup created successfully!');
                window.location.reload();
            } else {
                alert('Error: ' + data.message);
                console.error(data.output);
            }
        })
        .catch(error => {
            alert('An error occurred: ' + error.message);
            console.error(error);
        })
        .finally(() => {
            this.disabled = false;
            this.textContent = 'Create Backup';
        });
    });
</script>
@endpush
@endsection

@php
    function formatBytes($bytes, $precision = 2) {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
@endphp