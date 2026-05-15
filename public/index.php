<?php

session_start();

require_once '../config/config.php';
require_once '../app/core/App.php';
require_once '../app/core/Controller.php';
require_once '../app/core/Database.php';
require_once '../app/core/Security.php';
if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_token'])) {
    require_once '../app/models/User.php';
    $db_temp = new Database();
    $userModel = new User();
    $user = $userModel->getUserByRememberToken($_COOKIE['remember_token']);
    if ($user) {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['username'] = $user->username;
        $_SESSION['role'] = $user->role;
    }
}

$app = new App();
