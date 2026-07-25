<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Keuangan;

class CleanupUnusedImages extends Command
{
    protected $signature = 'storage:cleanup-images';
    protected $description = 'Hapus image di storage yang tidak memiliki referensi di database';

    public function handle()
    {
        // 1. Ambil dari DB dan bersihkan prefix
        $imagesInDatabase = Keuangan::whereNotNull('bukti')
                            ->pluck('bukti')
                            ->map(fn($path) => str_replace('storage/', '', $path))
                            ->toArray();

        // 2. Ambil semua file yang ada di folder storage (misal folder 'bukti')
        $allFilesOnStorage = Storage::disk('public')->files('bukti');

        // 3. Cari selisihnya (file yang ada di storage tapi tidak ada di DB)
        $unusedFiles = array_diff($allFilesOnStorage, $imagesInDatabase);

        if (empty($unusedFiles)) {
            $this->info('Tidak ada file sampah. Storage bersih!');
            return;
        }

        // 4. Proses Hapus
        $count = 0;
        foreach ($unusedFiles as $file) {
            // Proteksi: Jangan hapus file tersembunyi seperti .gitignore
            if (str_starts_with(basename($file), '.')) continue;

            Storage::disk('public')->delete($file);
            $this->warn("Dihapus: {$file}");
            $count++;
        }

        $this->info("$count file berhasil dibersihkan.");
    }
}