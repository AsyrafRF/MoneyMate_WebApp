<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Notifications\BudgetWarningDigestService;

class GenerateWarningDigest extends Command
{
    protected $signature = 'notifications:warning-digest';
    protected $description = 'Generate digest budget warning notifications';

    public function handle(BudgetWarningDigestService $service)
    {
        $service->handle();

        $this->info('Notifikasi ringkasan peringatan anggaran berhasil diproses.');
    }
}
