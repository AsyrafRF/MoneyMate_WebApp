<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;

class PurgeDeletedUsers extends Command
{
    // Nama command yang akan dijalankan di terminal/cron
    protected $signature = 'user:purge-suspended';
    protected $description = 'Hapus permanen akun user yang sudah ditangguhkan lebih dari 7 hari';

    public function handle()
    {
        // Cari user yang soft-deleted lebih dari 7 hari yang lalu
        $days = 7;
        $usersToPurge = User::onlyTrashed()
            ->where('deleted_at', '<=', Carbon::now()->subDays($days))
            ->get();

        foreach ($usersToPurge as $user) {
            $user->forceDelete(); // Menghapus permanen dari DB
        }

        $this->info(count($usersToPurge) . " akun user telah dihapus permanen.");
    }
}