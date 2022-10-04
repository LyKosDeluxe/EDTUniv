<?php

namespace app\stockage;

interface FacadeStockage
{

    public static function get(String $key) : mixed;
    public static function remove(String $key) : void;
    public static function set(array... $tab) : void;
    public static function exist(String $key) : bool;
    public static function type() : TypeStockage;

}