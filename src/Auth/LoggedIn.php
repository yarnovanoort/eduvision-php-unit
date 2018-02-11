<?php
namespace Phpunittest\Auth;

/**
 * Class LoggedIn
 * @package Phpunittest\Auth
 */
class LoggedIn
{

    /**
     * @return bool|Phpunittest\Models\User
     */
    public static function user()
    {
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
            return $user;
        } else {
            return false;
        }
    }
}
