<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\CheckLowStock::class,
        Commands\TestBrevoConnection::class,
        Commands\SetupSystem::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // Verificar stock bajo todos los días a las 9:00 AM
        $schedule->command('inventory:check-low-stock')
                 ->dailyAt('09:00')
                 ->emailOutputOnFailure('admin@inventario.com');

        // También verificar cada lunes a las 8:00 AM
        $schedule->command('inventory:check-low-stock')
                 ->weeklyOn(1, '08:00');
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
