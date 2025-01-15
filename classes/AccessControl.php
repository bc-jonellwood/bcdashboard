<?php
// Created: 2025/01/15 11:36:46
// Last modified: 2025/01/15 11:53:32

class AccessControl
{
    public static function enforce($accessRequired)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        include_once(dirname(__FILE__) . '/../classes/User.php');
        include_once(dirname(__FILE__) . '/../auth/UserAuth.php');

        $user = new User();
        $auth = new UserAuth();

        $userAccess = $user->getUserRoleId($_SESSION['userID']);
        if (!$auth->checkUserAccess($userAccess, $accessRequired)) {
            header("Location: /403.html");
            exit;
        }
    }
}
