<?php

namespace ECommerce\Public;

require_once __DIR__ . '/../vendor/autoload.php';

use ECommerce\App\Service\UsersService;

session_start();

if (UsersService::isLoggedIn()) {
    session_destroy();
    header('Location: index.php');
    exit();
}

header('Location: index.php');
exit;
