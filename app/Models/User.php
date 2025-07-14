<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Helpers\AdminHelper;

class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    public function isAdmin()
    {
        return $this->role === 'admin' && AdminHelper::isAdminEmail($this->email);
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    public function isHardcodedAdmin()
    {
        return AdminHelper::isAdminEmail($this->email);
    }

    // Override untuk mencegah admin dihapus
    public function delete()
    {
        if ($this->isHardcodedAdmin()) {
            throw new \Exception('Cannot delete hardcoded admin account');
        }
        
        return parent::delete();
    }
}