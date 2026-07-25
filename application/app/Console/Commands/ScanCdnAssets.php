<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ScanCdnAssets extends Command
{
    // Nama perintah di terminal
    protected $signature = 'cdn:scan';
    protected $description = 'Scan Blade files for CDNs and generate a grouped config/cdn.php';

    public function handle()
    {
        $viewPath = resource_path('views');
        $configFile = config_path('cdn.php');

        if (!File::exists($viewPath)) {
            $this->error("Direktori views tidak ditemukan.");
            return Command::FAILURE;
        }

        $this->info("Sedang memindai file Blade di {$viewPath}...");

        // Regex untuk menangkap URL CDN (mengabaikan domain internal & media sosial)
        $regex = '/https:\/\/(?!([a-z0-9-]+\.)?moneymate\.id|instagram\.com|x\.com|tiktok\.com|linkedin\.com|wa\.me|discord\.gg|github\.com|google\.com|polibatam\.ac\.id)[^\s"\']+/i';

        $foundCdns = [];
        $files = File::allFiles($viewPath);

        foreach ($files as $file) {
            $content = File::get($file->getRealPath());
            
            if (preg_match_all($regex, $content, $matches)) {
                foreach ($matches[0] as $url) {
                    // Bersihkan karakter sisa HTML di ujung URL
                    $url = rtrim($url, ')"\'><');
                    $foundCdns[$url] = $file->getRelativePathname();
                }
            }
        }

        if (empty($foundCdns)) {
            $this->warn("Tidak ada CDN pihak ketiga yang terdeteksi.");
            return Command::SUCCESS;
        }

        // Inisialisasi struktur grup
        $configData = [
            'styles'  => [],
            'scripts' => [],
            'fonts'   => [],
        ];

        // Tempat menyimpan mapping untuk tabel output petunjuk
        $tableRows = [];

        foreach ($foundCdns as $url => $filePath) {
            // Analisis path untuk menentukan nama key dan grup
            $parsedUrl = parse_url($url, PHP_URL_PATH);
            $pathPieces = explode('/', $parsedUrl);
            $filename = end($pathPieces);
            
            // Generate nama key yang bersih
            $keyName = str_replace(['.', '-', '@'], '_', strtolower($filename));
            if (empty($keyName)) {
                $keyName = 'asset_' . substr(md5($url), 0, 6);
            }

            // Logika Penentuan Grup (Pintar)
            $group = 'scripts'; // Default group jika tidak terdeteksi
            
            if (str_contains($url, 'fonts.googleapis.com') || str_contains($url, 'fonts.bunny.net') || str_contains($url, 'fonts.gstatic.com')) {
                $group = 'fonts';
                // Khusus google fonts core URL, beri nama key yang lebih manusiawi
                if (str_contains($url, 'css2')) {
                    $keyName = 'google_fonts_inter' . (str_contains($url, 'Heebo') ? '_heebo' : '') . (str_contains($url, 'Poppins') ? '_poppins' : '');
                }
            } elseif (str_ends_with($parsedUrl, '.css') || str_contains($url, '/css/') || str_contains($url, '/css?')) {
                $group = 'styles';
            } elseif (str_ends_with($parsedUrl, '.js') || str_contains($url, '/js/') || str_contains($parsedUrl, 'chart.js') || str_contains($parsedUrl, 'sweetalert2')) {
                $group = 'scripts';
            }

            // Masukkan ke dalam array group
            $configData[$group][$keyName] = $url;

            // Simpan data untuk kebutuhan tabel konsol
            $tableRows[] = [
                ucfirst($group),
                $keyName,
                "config('cdn.{$group}.{$keyName}')",
                $filePath
            ];
        }

        // Hapus grup jika ternyata kosong (tidak ada aset di grup tersebut)
        $configData = array_filter($configData);

        // Tulis array yang sudah dikelompokkan ke file config/cdn.php
        $this->writeConfigFile($configFile, $configData);

        $this->info("\nSukses! File config/cdn.php berhasil diperbarui dengan struktur terkelompok.");
        
        // Tampilkan tabel panduan untuk developer
        $this->newLine();
        $this->info("Gunakan referensi berikut untuk mengubah file Blade Anda:");
        $this->table(['Grup', 'Key Nama', 'Blade Helper Syntax', 'Lokasi File Asli'], $tableRows);

        return Command::SUCCESS;
    }

    private function writeConfigFile($path, array $data)
    {
        $export = var_export($data, true);
        
        // Formatting php array modern agar rapih (mengganti array() ke [])
        $export = str_replace("=> \n", "=> ", $export);
        $export = str_replace("array (\n", "[\n", $export);
        $export = str_replace("array (", "[", $export);
        $export = preg_replace("/\),\n/", "],\n", $export);
        $export = preg_replace("/\s+=>/", " =>", $export);
        $export = rtrim($export, ')') . ']';

        $content = "<?php\n\n// File ini di-generate otomatis secara berkala melalui php artisan cdn:scan\nreturn {$export};\n";
        
        File::put($path, $content);
    }
}