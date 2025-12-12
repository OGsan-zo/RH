<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\CalculerSoldesCongesJob;

class CalculerSoldesCongesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'conges:calculer-soldes {--force : Forcer le recalcul même si les soldes existent}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculer les soldes de congés pour tous les employés';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Calcul des soldes de congés en cours...');

        try {
            CalculerSoldesCongesJob::dispatch();
            $this->info('✅ Job de calcul des soldes lancé avec succès !');
            $this->info('Les soldes seront calculés en arrière-plan.');
        } catch (\Exception $e) {
            $this->error('❌ Erreur : ' . $e->getMessage());
        }
    }
}
