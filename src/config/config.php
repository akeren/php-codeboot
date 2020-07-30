<?php
/*
**  global settings array
*/
$GLOBALS['config'] = array(
    'mysql' => array(
        'url' => 'mysql:host=127.0.0.1;dbname=codeboot',
        'username' => 'root',
        'password' => ''
    ),
    'remember' => array(
        'cookie_name' => 'hash',
        'cookie_expiry' => 604800
    ),
    'session' => array(
        'session_name' => 'user',
        'token_name' => 'token'
    )
);
