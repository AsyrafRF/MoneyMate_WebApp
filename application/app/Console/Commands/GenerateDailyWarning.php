<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Notifications\BudgetWarningService;

class GenerateDailyWarning extends Command
{
    protected $signature = 'notifications:warning';
    protected $description = 'Generate daily budget warning notifications';

    public function handle(BudgetWarningService $service)
    {
        $service->handle();

        $this->info('Notifikasi anggaran berhasil diproses.');
    }
}
