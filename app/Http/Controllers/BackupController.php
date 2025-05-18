<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BackupController extends Controller
{
    public function index()
    {
        $backups = Storage::disk('local')->files('private');
        return view('backup.index', compact('backups'));
    }

    public function create()
    {
        Artisan::call('backup:run', ['--only-db' => true]);
        return redirect()->back()->with('success', 'Backup created.');
    }

    public function download($file)
    {
        $path = storage_path("app/private/{$file}");
        if (!file_exists($path)) {
            abort(404);
        }

        return response()->download($path);
    }

    public function restore($file)
    {
        $path = storage_path("app/private/{$file}");
        $dbName = config('database.connections.pgsql.database');
        $username = config('database.connections.pgsql.username');
        $password = config('database.connections.pgsql.password');

        $command = "pgsql -u {$username} -p{$password} {$dbName} < {$path}";
        exec($command);

        return redirect()->back()->with('success', 'Database restored.');
    }
}

