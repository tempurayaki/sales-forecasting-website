<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Helpers\AdminHelper;

class AdminSeeder extends Seeder
{
    public function run()
    {
        AdminHelper::createOrUpdateAdmin();
        $this->command->info('Hardcoded admin account created/updated');
    }
}