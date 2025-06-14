<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
class BackupController extends Controller
{
    public function index(){
        $backupDisk = Storage::disk(config('backup.backup.destination.disks')[0]);
        $backupFiles = $backupDisk->files(config('backup.backup.name'));
        
        // Sort files by modified time, newest first
        $backupFiles = collect($backupFiles)
            ->filter(function ($file) {
                return pathinfo($file, PATHINFO_EXTENSION) === 'zip';
            })
            ->sortByDesc(function ($file) use ($backupDisk) {
                return $backupDisk->lastModified($file);
            })
            ->values()
            ->all();
        
        return view('backup.index', compact('backupFiles', 'backupDisk'));
    }

    // public function create()
    // {
    //     try {
    //     $process = new Process([
    //         PHP_BINARY, // Uses the same PHP binary that's running the current script
    //         base_path('artisan'), // base_path() points to project root
    //         'backup:run'
    //     ]);
        
    //     $process->setTimeout(null);
    //     $process->run();
        
    //     if (!$process->isSuccessful()) {
    //         throw new ProcessFailedException($process);
    //     }
        
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Backup created successfully!',
    //         'output' => $process->getOutput()
    //     ]);
    // } catch (\Exception $e) {
    //     return response()->json([
    //         'success' => false,
    //         'message' => 'Backup failed: ' . $e->getMessage(),
    //         'output' => isset($process) ? $process->getErrorOutput() : ''
    //     ], 500);
    // }
    // }

    public function download($file){
        $backupDisk = Storage::disk(config('backup.backup.destination.disks')[0]);
        $filePath = config('backup.backup.name') . '/' . $file;
        
        if (!$backupDisk->exists($filePath)) {
            abort(404);
        }
        
        return $backupDisk->download($filePath);
    }

    public function delete($file){
        $backupDisk = Storage::disk(config('backup.backup.destination.disks')[0]);
        $filePath = config('backup.backup.name') . '/' . $file;
        
        if (!$backupDisk->exists($filePath)) {
            abort(404);
        }
        
        $backupDisk->delete($filePath);
        
        return redirect()->route('backup.index')
            ->with('success', 'Backup deleted successfully');
    }
}

