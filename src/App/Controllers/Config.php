<?php

namespace App\Controllers;

/*
**  grab the database settings array
** from the config directory
*/

class Config
{
    public static function get($path = null)
    {
        if ($path) {
            $config = $GLOBALS['config'];
            $path = explode('/', $path);

            foreach ($path as $bit) {
                if (isset($config[$bit])) {
                    $config = $config[$bit];
                } else {
                    return false;
                }
            }

            return $config;
        }

        return false;
    }
}
