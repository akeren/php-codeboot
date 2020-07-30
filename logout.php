<?php

use App\Controllers\User;
use App\Helpers\Redirect;

require_once './src/core/bootstrap.php';

$user = new User();
$user->logout();

Redirect::to('index');
