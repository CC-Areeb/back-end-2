<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:admin-create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to create users who are admins';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('What is your name?');
        $email = $this->ask('Enter an email');
        $password = $this->secret('Enter a temporary password');
        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'account_status' => 'active',
            'admin' => true,
        ]);
        $this->info('Admin account created successfully!');
    }
}
