<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class CleanStorage extends Command
{
    protected $signature = 'storage:clean 
                            {path=public : Folder di storage/app yang ingin dibersihkan (default: public)} 
                            {--force : Lewati konfirmasi manual}';

    protected $description = 'Hapus semua file di storage/app path tertentu, kecuali file penting seperti .gitignore dan default.png';

    public function handle()
    {
        $relativePath = $this->argument('path');
        $storagePath = storage_path('app/' . $relativePath);

        // Pastikan folder benar-benar ada
        if (!File::exists($storagePath)) {
            $this->error("❌ Folder tidak ditemukan: {$storagePath}");
            return 1;
        }

        // Konfirmasi manual (kecuali jika pakai --force)
        if (!$this->option('force')) {
            if (!$this->confirm("⚠️  Yakin ingin menghapus SEMUA file di {$storagePath}?")) {
                $this->info('❎ Dibatalkan.');
                return 0;
            }
        }

        // File yang tidak boleh dihapus
        $excluded = ['.gitignore', 'default.png', 'readme.txt'];

        $deleted = 0;
        $skipped = 0;

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($storagePath, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($iterator as $file) {
            $fileName = $file->getFilename();

            if (in_array($fileName, $excluded)) {
                $skipped++;
                continue;
            }

            if ($file->isDir()) {
                @rmdir($file->getRealPath());
            } else {
                @unlink($file->getRealPath());
                $deleted++;
            }
        }

        $this->newLine();
        $this->info("✅ Pembersihan selesai!");
        $this->line("📦 Folder: {$storagePath}");
        $this->line("🗑️  File dihapus: {$deleted}");
        $this->line("🚫 File dilewati: {$skipped}");
        $this->newLine();

        return 0;
    }
}
