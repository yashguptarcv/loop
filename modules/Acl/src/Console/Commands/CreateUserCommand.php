<?php

namespace Modules\Acl\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Modules\Acl\Models\Admin;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin with name, email, and a hashed password';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Step 1: Ask for name
        $name = $this->ask('Enter user name');

        // Step 2: Ask for email
        $email = $this->ask('Enter user email');

        // Step 3: Ask for password (hidden input)
        $password = $this->secret('Enter user password');

        // Step 4: Validate inputs
        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ], [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            $this->error('Validation failed: ' . implode(' ', $validator->errors()->all()));
            return;
        }

        // Step 5: Create user
        $user = Admin::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role_id' =>1
        ]);

        $this->info("Admin User created successfully!");
        $this->info("Name: {$user->name}");
        $this->info("Email: {$user->email}");
    }
}
