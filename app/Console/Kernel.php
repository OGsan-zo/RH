<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\CalculerSoldesCongesJob;
use App\Jobs\VerifierAlertesCongesJob;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Calculer les soldes de congés le 1er janvier de chaque année
        $schedule->job(new CalculerSoldesCongesJob)
            ->yearlyOn(1, 1, '00:00');

        // Vérifier les alertes de congés tous les jours à 8h du matin
        $schedule->job(new VerifierAlertesCongesJob)
            ->dailyAt('08:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
