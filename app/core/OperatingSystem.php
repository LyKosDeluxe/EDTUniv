<?php

namespace app\core;

use app\stockage\CookieStockage;

class OperatingSystem
{

    public static function isChrome() : bool
    {
        if (isset($_SERVER['HTTP_USER_AGENT']))
            if (strlen(strstr($_SERVER['HTTP_USER_AGENT'], "Chrome")) > 0) return true;
        else return false;
        return false;
    }

    public static function isAndroid()
    {
        $android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");

        /**
         * Check if user already use PWA.
         */

        $useAndroid = false;
        if(isset($_GET['PWA'])) $useAndroid = false;
        if($android == true) $useAndroid = true;
        return $useAndroid;
    }
    public static function isApple()
    {
        $ipod = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
        $iphone = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
        $ipad = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");

        $apple = false;
        if($ipad OR $iphone or $ipod) $apple = true;
        if(isset($_GET['PWA'])) $apple = false;
        return $apple;
    }

    /**
     * @return bool true if user is using pwa
     */
    public static function isPwa()
    {
        return CookieStockage::exist('pwa');
    }

}