<?php

namespace app\stockage;

class SessionStockage implements FacadeStockage, FacadeMultiLevelStockage
{

    public static function get(String $key) : mixed
    {
        return $_SESSION[$key];
    }

    public static function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public static function set(array... $arr) : void
    {
        foreach ($arr as $r)
        {
            $_SESSION[$r[0]] = $r[1];
        }
    }

    public static function exist(string $key): bool
    {
        return (isset($_SESSION[$key]));
    }

    public static function type(): TypeStockage
    {
        return TypeStockage::TYPE_SESSION;
    }


    public static function multidimentionnalSet(string $base, mixed $value) : void
    {
        $_SESSION[$base][] = $value;
    }

}