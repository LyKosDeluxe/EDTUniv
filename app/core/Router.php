<?php

namespace app\core;

class Router
{

    public static function start($matchs)
    {
        if( is_array($matchs) && is_callable( $matchs['target'] ) ) {
            call_user_func_array( $matchs['target'], $matchs['params'] );
        } else {
            // no route was matched
            header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
        }
    }

}