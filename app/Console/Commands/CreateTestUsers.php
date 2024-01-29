<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CreateTestUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-test-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create test users for your application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->createTestUsers();
    }

    protected function createTestUsers()
    {
        // Create test users
        $count = $this->ask('How many test users do you want to create?');

        if (!is_numeric($count) || $count <= 0) {
            $this->error('Invalid input. Please enter a positive numeric value.');
            return;
        }

        User::factory()->count($count)->create();
        $this->info("Successfully created $count test users.");
    }
}
