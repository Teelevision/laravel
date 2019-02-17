<?php

namespace App\Redaxo;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable;

/**
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property string $login
 * @property string $password
 * @property bool $status
 * @property bool $admin
 * @property string $language
 * @property string $startpage
 * @property string|null $role
 * @property-read UserRole[]|UserRoleCollection $roles
 * @property int|null $login_tries
 * @property string $createuser
 * @property string $updateuser
 * @property Carbon $lasttrydate
 * @property string|null $session_id
 * @property string|null $cookiekey
 * @property int $revision
 * @property string|null $email
 * @property Carbon $lastlogin
 */
class User extends Model implements Authenticatable, Authorizable
{
    use \Illuminate\Auth\Authenticatable, \Illuminate\Foundation\Auth\Access\Authorizable;

    protected $dates = ['lasttrydate', 'lastlogin'];

    protected $casts = [
        'status' => 'bool',
        'admin' => 'bool',
    ];


    public function getRolesAttribute(): UserRoleCollection
    {
        $roleIds = explode(',', $this->role);

        return UserRole::findMany($roleIds);
    }

    public function hasPermission(string $permission): bool
    {
        return $this->roles->hasPermission($permission);
    }

    public function hasClangPermission(int $clang): bool
    {
        return $this->roles->hasClang($clang);
    }
}