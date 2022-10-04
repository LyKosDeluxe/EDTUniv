<?php

namespace app\stockage;

class CookieStorage implements FacadeStockage
{

    public static function get(String $key) : mixed
    {
        return $_COOKIE[$key];
    }

    public static function remove(String $key): void
    {
        unset($_COOKIE[$key]);
    }

    public static function exist(String $key): bool
    {
        return isset($_COOKIE[$key]) && !empty($_COOKIE[$key]);
    }

    public static function set(string $key, mixed $value) : void
    {
        setcookie($key, $value);
    }

    public static function type(): TypeStockage
    {
        return TypeStockage::TYPE_COOKIE;
    }

}