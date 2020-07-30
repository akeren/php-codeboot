<?php

use App\Models\DB;

require_once './src/core/bootstrap.php';

/**
 * Using the generic query method to get records
 */
$users = DB::getInstance()->query(
    "SELECT * FROM users WHERE username = ? OR username = ?",
    array('kater', 'fabian')
);

/**
 * How to check for errors
 */
if ($users->error()) {
    echo 'No user!';
} else {
    foreach ($users->results() as $user) {
        pretty($user);
    }
}


/**
 * Getting an individual record from the DB
 */

$user = DB::getInstance()->get('users', array('username', '=', 'kater'));
pretty($user->results());
