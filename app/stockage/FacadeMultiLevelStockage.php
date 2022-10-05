<?php

namespace app\stockage;

interface FacadeMultiLevelStockage
{

    public static function multidimentionnalSet(String $base, mixed $value) : void;

}