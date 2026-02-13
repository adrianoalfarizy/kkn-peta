<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class BackupDatabase extends Command
{
    protected $signature = 'db:backup {--keep=7 : Number of days to keep backups}';
    protected $description = 'Backup database SQLite';

    public function handle()
    {
        $dbPath = database_path('database.sqlite');
        
        if (!File::exists($dbPath)) {
            $this->error('Database file not found!');
            return 1;
        }

        $backupDir = storage_path('app/backups');
        if (!File::exists($backupDir)) {
            File::makeDirectory($backupDir, 0755, true);
        }

        $filename = 'backup_' . date('Y-m-d_His') . '.sqlite';
        $backupPath = $backupDir . '/' . $filename;

        if (File::copy($dbPath, $backupPath)) {
            $this->info("Database backed up successfully: {$filename}");
            
            // Clean old backups
            $this->cleanOldBackups($backupDir, $this->option('keep'));
            
            return 0;
        }

        $this->error('Backup failed!');
        return 1;
    }

    protected function cleanOldBackups(string $dir, int $keepDays): void
    {
        $files = File::files($dir);
        $cutoff = now()->subDays($keepDays)->timestamp;

        foreach ($files as $file) {
            if ($file->getMTime() < $cutoff) {
                File::delete($file->getPathname());
                $this->info("Deleted old backup: {$file->getFilename()}");
            }
        }
    }
}
