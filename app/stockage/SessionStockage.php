<?php

namespace app\stockage;

class SessionStockage implements FacadeStockage
{

    public static function get(String $key)
    {
        // TODO: Implement get() method.
    }

    public static function remove(string $key): void
    {
        // TODO: Implement remove() method.
    }

    public static function set(string $key, $value)
    {
        // TODO: Implement set() method.
    }

    public static function exist(string $key): bool
    {
        // TODO: Implement exist() method.
    }

    public static function type(): TypeStockage
    {
        return TypeStockage::TYPE_SESSION;
    }
}