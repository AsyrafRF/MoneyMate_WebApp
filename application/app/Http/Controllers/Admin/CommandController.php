<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Exception;

class CommandController extends Controller
{
    public function optimize()
    {
        // Hilangkan batasan waktu eksekusi skrip untuk proses deploy yang lama
        set_time_limit(0); 
        ini_set('max_execution_time', 0);

        try {
            $logOutput = "=== START REDEPLOY & OPTIMIZATION ===" . PHP_EOL;

            // Helper untuk eksekusi Artisan Command secara bersih
            $runArtisan = function($command, $parameters = []) use (&$logOutput) {
                try {
                    // Artisan::call mengembalikan status code (0 = success)
                    $exitCode = Artisan::call($command, $parameters);
                    $output = Artisan::output();
                    
                    $logOutput .= PHP_EOL . "[COMMAND]: php artisan $command " . (!empty($parameters) ? json_encode($parameters) : "") . PHP_EOL;
                    $logOutput .= "Status: " . ($exitCode === 0 ? "SUCCESS" : "FAILED (Code: $exitCode)") . PHP_EOL;
                    $logOutput .= trim($output) . PHP_EOL;
                } catch (Exception $cmdException) {
                    $logOutput .= PHP_EOL . "[ERROR IN COMMAND $command]: " . $cmdException->getMessage() . PHP_EOL;
                }
                $logOutput .= str_repeat("-", 40) . PHP_EOL;
            };

            // 1. Masuk ke Maintenance Mode (Aplikasi "Down" sementara untuk user agar aman)
            // --refresh=15 artinya browser user akan auto-refresh tiap 15 detik menunggu web up lagi
            $runArtisan('down', ['--refresh' => 15, '--secret' => 'PBL-TRPL517621A@MonMat']);

            // 2. Bersihkan Cache yang usang (Opsional tapi baik untuk memastikan tidak ada konflik)
            $runArtisan('cache:clear');

            // 3. Jalankan Migrasi Database (HANYA MIGRATION, TANPA SEED)
            // --force wajib di production untuk bypass konfirmasi
            $runArtisan('migrate', ['--force' => true]);

            // 4. Proses Optimasi Produksi (Caching Komponen Utama)
            $runArtisan('optimize');     // Meng-cache Config dan Routes sekaligus
            $runArtisan('view:cache');   // Meng-compile dan meng-cache seluruh blade views
            $runArtisan('event:cache');  // Meng-cache Events & Listeners (jika ada)

            // 5. Restart Queue Worker (KRUSIAL DI PRODUCTION)
            // Memaksa background worker untuk memuat ulang kode PHP terbaru yang baru di-deploy
            $runArtisan('queue:restart');

            // 6. Jalankan Kembali Aplikasi (Maintenance Mode OFF)
            $runArtisan('up');

            $logOutput .= PHP_EOL . "=== REDEPLOY SUCCESSFUL ===";

            // Catat juga ke file log internal Laravel untuk arsip admin
            Log::info("System manual redeploy executed successfully.");

            return response($logOutput, 200)->header('Content-Type', 'text/plain');

        } catch (Exception $e) {
            // Jika gagal di tengah jalan, pastikan aplikasi dinyalakan kembali agar tidak stuck di maintenance mode
            Artisan::call('up');
            
            Log::error("Fatal Error during redeploy: " . $e->getMessage());
            return response("Terjadi kesalahan fatal: " . $e->getMessage(), 500)->header('Content-Type', 'text/plain');
        }
    }
}