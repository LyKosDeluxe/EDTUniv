<?php

namespace app\core;

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
        if(isset($_GET['PWA'])) $android = false;
        return $android;
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

    public static function isPwa()
    {
        return str_contains($_SERVER['REQUEST_URI'], "pwa");
    }

}