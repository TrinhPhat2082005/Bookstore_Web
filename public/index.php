<?php
// bookstore_web/public/index.php
// Entry point for the MVC application

session_start();

require_once '../config/config.php';
require_once '../app/core/App.php';
require_once '../app/core/Controller.php';
require_once '../app/core/Database.php';

$app = new App();
