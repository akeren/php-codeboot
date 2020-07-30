<?php
/*
** This is the core of the application
** This file must be included on all pages
** To make use of the application logic
*/
session_start();
require_once __DIR__ . './../utils/sanitize.php';
require_once __DIR__ . './../config/config.php';
require_once __DIR__ . './../../vendor/autoload.php';
