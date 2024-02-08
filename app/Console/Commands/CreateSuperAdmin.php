<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-super-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for creating a super admin users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('Super admin name: ');
        $email = $this->ask('Super admin email: ');
        $password = $this->ask('Super admin password: ');
        User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password ? Hash::make($password) : 'password',
            'super_admin' => 1,
            'admin' => 0,
            'user' => 0,
            'account_status' => 'active'
        ]);
        $this->info("Successfully created super admin user.");
    }
}
