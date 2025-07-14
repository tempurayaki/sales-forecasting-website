<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\AdminHelper;

class SetupAdmin extends Command
{
    protected $signature = 'admin:setup';
    protected $description = 'Setup or update hardcoded admin account';

    public function handle()
    {
        try {
            $admin = AdminHelper::createOrUpdateAdmin();
            $this->info("Admin account setup successfully!");
            $this->info("Email: " . $admin->email);
            $this->info("Password: Check your .env file");
        } catch (\Exception $e) {
            $this->error("Error setting up admin: " . $e->getMessage());
        }
    }
}