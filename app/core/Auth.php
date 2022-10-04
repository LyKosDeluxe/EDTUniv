<?php

namespace app\core;

use app\stockage\CookieStockage;

class Auth
{

    public static function isAuth() : bool
    {
        return CookieStockage::exist("tp") && CookieStockage::exist("td") && CookieStockage::exist("username");
    }

    public static function logout() : void {
        CookieStockage::remove("tp");
        CookieStockage::remove("td");
    }

    public static function getUsername()
    {
        return htmlspecialchars(CookieStockage::get('username'));
    }
    public static function login($username, array... $v)
    {
        CookieStockage::basicSet('username', $username);
        CookieStockage::set($v);
    }
}