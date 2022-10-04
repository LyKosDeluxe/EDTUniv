<?php

namespace app\stockage;

class CookieStockage implements FacadeStockage
{

    public static function get(String $key) : mixed
    {
        return $_COOKIE[$key];
    }

    public static function remove(String $key): void
    {
        unset($_COOKIE[$key]);
        setcookie($key, "", time() - 3600);
    }

    public static function exist(String $key): bool
    {
        return isset($_COOKIE[$key]) && !empty($_COOKIE[$key]);
    }

    public static function set(array... $tab) : void
    {

        foreach ($tab as $v)
        {
            setcookie($v[0][0], $v[0][1], time() + 100000000000000);
            setcookie($v[1][0], $v[1][1], time() + 100000000000000);
        }
    }
    public static function basicSet(String $key, String $value) : void
    {
        setcookie($key, $value, time() + 100000000000000);
    }

    public static function type(): TypeStockage
    {
        return TypeStockage::TYPE_COOKIE;
    }

}