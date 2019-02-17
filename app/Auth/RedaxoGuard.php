<?php

namespace App\Auth;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;

class RedaxoGuard implements Guard
{
    use GuardHelpers;


    public function __construct(UserProvider $userProvider)
    {
        $this->provider = $userProvider;
    }

    /**
     * Get the currently authenticated user.
     *
     * @return Authenticatable|null
     */
    public function user()
    {
        if (!$this->user && ($redaxoUser = $this->getRedaxoUser())) {
            $this->user = $this->retrieveUserByRedaxoUser($redaxoUser);
        }

        return $this->user;
    }

    /**
     * @return \rex_user|null
     */
    protected function getRedaxoUser()
    {
        return \rex::getUser();
    }

    /**
     * @param \rex_user $redaxoUser
     * @return Authenticatable|null
     */
    protected function retrieveUserByRedaxoUser(\rex_user $redaxoUser)
    {
        $id = (int)$redaxoUser->getId();
        return $this->provider->retrieveById($id);
    }

    /**
     * Validate a user's credentials.
     *
     * @param  array $credentials
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        // disable validation of credentials
        return false;
    }
}