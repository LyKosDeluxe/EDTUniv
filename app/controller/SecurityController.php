<?php

namespace app\controller;

use app\core\Auth;
use app\core\OperatingSystem;
use app\exception\AlreadyAuthException;
use app\exception\InputAuthException;
use app\exception\NotAuthException;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class SecurityController extends Controller
{

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function main(): String
    {
        if (Auth::isAuth()) {
            header('Location: /edt');
            return '';
        }
        return $this->render(
            'security.html.twig',
            [
                'android' => OperatingSystem::isAndroid(),
                'iphone' => OperatingSystem::isApple(),
                'pwa' => OperatingSystem::isPwa()
            ]
        );
    }

    public function login()
    {
        try {
            if ((isset($_POST['tdGrp']) && is_numeric($_POST['tdGrp'])) && (isset($_POST['tpGrp']) && is_numeric($_POST['tpGrp'])) && isset($_POST['username']) && !empty($_POST['username'])) {
                if (Auth::isAuth()) throw new AlreadyAuthException();

                $tp = intval(htmlspecialchars($_POST['tpGrp']));
                $td = intval(htmlspecialchars($_POST['tdGrp']));
                if ($tp == 0 or $td == 0) throw new InputAuthException();
                Auth::login(htmlspecialchars($_POST['username']), ["tp", $tp], ["td", $td]);
                header('Location: /edt');
            }
        } catch (AlreadyAuthException | InputAuthException $e) {
            header('Location: /');
        }
    }
    public function logout(): void
    {
        try {
            if (Auth::isAuth()) Auth::logout();
            else throw new NotAuthException();
        } catch (NotAuthException $e) {
        }
        header('Location: /');
    }
    public function getName(): string
    {
        return 'SecurityController';
    }
}
