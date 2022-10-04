<?php

namespace app\core;

use app\controller\Controller;
use app\controller\SecurityController;
use app\controller\TimeTableController;

class Controllers
{
    public const SECURITY_CONTROLLER = 0;
    public const TIMETABLE_CONTROLLER = 1;

    private array $controllers = [];

    public function __construct()
    {
        $this->controllers[self::SECURITY_CONTROLLER] = new SecurityController();
        $this->controllers[self::TIMETABLE_CONTROLLER] = new TimeTableController();
    }

    /**
     * @return array
     */
    public function getControllers(): array
    {
        return $this->controllers;
    }

}