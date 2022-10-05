<?php

namespace app\exception;

use app\core\FlashType;
use app\service\FlashService;

class InputAuthException extends \Exception
{

    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        FlashService::addFlash(FlashType::TYPE_ERROR, 'Vous devez rentrer tout les champs');
    }

}