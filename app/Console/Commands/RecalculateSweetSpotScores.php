<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SweetSpotScoringService;

class RecalculateSweetSpotScores extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sweetspot:recalculate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculate Sweet Spot scores for all customers';

    /**
     * Execute the console command.
     */
    public function handle(SweetSpotScoringService $service)
    {
        $this->info('Starting recalculation of Sweet Spot scores...');

        $service->calculateAll();

        $this->info('Recalculation complete.');
    }
}
