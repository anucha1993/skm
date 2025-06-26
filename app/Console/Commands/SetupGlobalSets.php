<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\GlobalSetService;

class SetupGlobalSets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'labour:setup-global-sets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup default Global Sets for Labour system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Setting up Global Sets...');

        try {
            // สร้าง Global Sets เริ่มต้น
            GlobalSetService::createDefaultGlobalSets();
            $this->info('✓ Global Sets created successfully');

            // สร้างสถานะเริ่มต้น
            GlobalSetService::createDefaultStatuses();
            $this->info('✓ Default statuses created successfully');

            $this->info('Global Sets setup completed!');

        } catch (\Exception $e) {
            $this->error('Error setting up Global Sets: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
