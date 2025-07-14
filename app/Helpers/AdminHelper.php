<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminHelper
{
    public static function getAdminCredentials()
    {
        return [
            'name' => env('ADMIN_NAME', 'Administrator'),
            'email' => env('ADMIN_EMAIL', 'admin@localhost'),
            'password' => env('ADMIN_PASSWORD', 'password'),
        ];
    }

    public static function isAdminEmail($email)
    {
        return $email === env('ADMIN_EMAIL');
    }

    public static function createOrUpdateAdmin()
    {
        $credentials = self::getAdminCredentials();
        
        return User::updateOrCreate(
            ['email' => $credentials['email']],
            [
                'name' => $credentials['name'],
                'email' => $credentials['email'],
                'password' => Hash::make($credentials['password']),
                'role' => 'admin',
            ]
        );
    }
}