<?php

namespace App\Http\Controllers\Lawyer;

use App\Exports\LawyerBackupExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class BackupController extends Controller
{
    /**
     * Download a styled .xlsx backup with 3 sheets:
     * Lawyer Profile, Clients, Cases.
     */
    public function export()
    {
        $lawyer = Auth::user()->lawyer;
        abort_unless($lawyer, 403);

        $lawyer->loadMissing('user', 'specializations');

        $slug = Str::slug($lawyer->user->name) ?: 'lawyer';
        $filename = "lawconnect-backup-{$slug}-" . now()->format('Y-m-d') . '.xlsx';

        return Excel::download(new LawyerBackupExport($lawyer), $filename);
    }
}
