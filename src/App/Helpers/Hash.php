<?php

namespace App\Helpers;

class Hash
{
    public static function make($string, $salt = '')
    {
        return hash('sha256', $string . $salt);
    }

    public static function salt($length)
    {
        return bin2hex(random_bytes($length));
    }

    public static function create($password)
    {
        return password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
    }

    public static function check($password, $hashPassword)
    {
        return password_verify($password, $hashPassword);
    }

    public static function unique()
    {
        return self::make(uniqid());
    }
}
