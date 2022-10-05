<?php

namespace app\service;

use app\core\FlashType;
use app\stockage\SessionStockage;

class FlashService
{

    public static function fetch()
    {
        if(!isset($_SESSION['flash'])) return;
        foreach($_SESSION['flash'] as $flash)
        {
            echo '<div class="error"><p><b>Erreur:</b> '.$flash.'</div></p>';
        }
    }

    public static function addFlash(FlashType $flashType, $value){
        SessionStockage::multidimentionnalSet('flash', $value);
    }

    public static function removeFlash()
    {
        SessionStockage::remove('flash');
    }


}