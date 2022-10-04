<?php

namespace app\controller;

use app\stockage\CookieStockage;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

abstract class Controller implements FacadeController
{


    public function toString() : void
    {
        echo "\n" . $this->getName();
    }

    /**
     * Use twig from symfony. Thanks composer
     * @param String $filePath
     * @param array $params
     * @throws RuntimeError
     * @throws LoaderError
     * @throws SyntaxError
     */
    public function render(String $filePath, array $params = []) : String
    {
        $loader = new FilesystemLoader('../app/view');
        $twig = new Environment($loader);
        return $twig->render($filePath, $params);
    }

}