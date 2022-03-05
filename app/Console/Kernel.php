<?php

namespace App\Console;

use App\Jobs\DeletePedidosAntigosJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [];
    protected function schedule(Schedule $schedule)
    {
        $schedule->job(new DeletePedidosAntigosJob)->daily();
    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
