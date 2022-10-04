<?php

namespace app\controller;

use app\api\SchoolTimeTable;
use app\core\Auth;
use app\core\OperatingSystem;
use app\stockage\CookieStockage;
use DateTime;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class TimeTableController extends Controller
{

    private SchoolTimeTable $api;
    public function __construct()
    {
        $this->api = new SchoolTimeTable();
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function main($week = null): string
    {
        $date = date("Y-m-d H:i:s");
        $week = date("W", strtotime($date));
        $year = date("Y", strtotime($date));

        $weekVal = $year.'-W';
        if(strlen($week) < 2) $weekVal.= '0'.$week; else $weekVal.=$week;

        //Check if user is authenticated
        if(!Auth::isAuth())
        {
            header('Location: /');
            return '';
        }






        //END CHECK;

        $this->api->fetchTimeTable();


        return $this->render('edt.html.twig', [
            'tp' => CookieStockage::get('tp'),
            'td' => CookieStockage::get('td'),
            'groupId' => $this->api->getGroupId(),
            'identifier'=>$this->api->fetchTimeTable(),
            'week' => $week,
            'year' => $year,
            'android' => OperatingSystem::isAndroid(),
            'iphone' => OperatingSystem::isApple(),
            'username' => Auth::getUsername(),
            'weekVal' => $weekVal,
            'options' => $this->fetchOptions(),
            'chrome' => OperatingSystem::isChrome(),
            'pwa' => OperatingSystem::isPwa()
        ]);
    }


    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function today(): string
    {
        $date = date("Y-m-d H:i:s");
        $week = date("W", strtotime($date));
        $year = date("Y", strtotime($date));
        $day = date("D", strtotime($date));

        $weekVal = $year.'-W';
        if(strlen($week) < 2) $weekVal.= '0'.$week; else $weekVal.=$week;

        //Check if user is authenticated
        if(!Auth::isAuth())
        {
            header('Location: /');
            return '';
        }
        $today = match($day){
            'Mon' => '0',
            'Tue' => '1',
            'Wed' => '2',
            'Thu' => '3',
            'Fri' => '4',
            'Sat' => '5',
            'Sun' => '6',
        };
        //END CHECK;

        $this->api->fetchTimeTable();


        return $this->render('today.html.twig', [
            'tp' => CookieStockage::get('tp'),
            'td' => CookieStockage::get('td'),
            'groupId' => $this->api->getGroupId(),
            'identifier'=>$this->api->fetchTimeTable(),
            'week' => $week,
            'android' => OperatingSystem::isAndroid(),
            'iphone' => OperatingSystem::isApple(),
            'today' => $today,
            'year' => $year,
            'pwa' => OperatingSystem::isPwa()
        ]);
    }

    public function fetchOptions()
    {
        $date = date("Y-m-d H:i:s");
        $week = date("W", strtotime($date)) - 33;
        $year = date("Y", strtotime($date));

        $options = [];
        for($i = $week; $i<($week + 10); $i++) {
            $monday = new DateTime;
            $sunday = new DateTime;
            $monday->setISODate($year, $i + 33, 1);
            $sunday->setISODate($year, $i + 33, 5);
            $options[] = [
                'Semaine n°'.$i.': ' . date_format($monday, 'Y-m-d').' - '.date_format($sunday, 'Y-m-d'),
                $i,
            ];
        }
        return $options;
    }

    public function getName(): string
    {
        return 'TimeTableController';
    }
}