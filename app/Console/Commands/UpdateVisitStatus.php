<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Visits;
use Carbon\Carbon;

class UpdateVisitStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'visits:update-visit-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Visits::where('verification', 'In progress')
            ->where('end_date', '<', Carbon::now())
            ->update(['verification' => 'Finished']);

        Visits::where('verification', 'Finished')
            ->where('start_date', '<', Carbon::now())
            ->where('end_date', '>', Carbon::now())
            ->update(['verification' => 'In progress']);

        $this->info('Visit statuses updated successfully.');
    }
}
