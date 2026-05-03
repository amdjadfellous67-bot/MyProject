<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BackupController extends Controller
{
    public function index()
    {
        return view('admin.backup.index');
    }

    public function create()
    {
        $dbPath = database_path('database.sqlite');
        
        if (!file_exists($dbPath)) {
            return back()->with('error', 'Database file not found');
        }
        
        $backupDir = storage_path('app/backups');
        if (!File::exists($backupDir)) {
            File::makeDirectory($backupDir, 0755, true);
        }
        
        $filename = 'hrflow_backup_' . date('Y-m-d_His') . '.sqlite';
        $backupPath = $backupDir . '/' . $filename;
        
        File::copy($dbPath, $backupPath);
        
        return response()->download($backupPath)->deleteFileAfterSend(true);
    }
}