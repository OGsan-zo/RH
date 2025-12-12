<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\CalculerSoldesCongesJob;

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

        // Optionnel : Exécuter aussi le 1er de chaque mois pour les mises à jour
        // $schedule->job(new CalculerSoldesCongesJob)
        //     ->monthlyOn(1, '00:00');
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
