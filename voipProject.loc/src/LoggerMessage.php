<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 25.01.2017
 * Time: 11:37
 */

namespace App;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class LoggerMessage
{
    public function sendInfoMessage($message, $params = null)
    {
        $log = new Logger('name');
        $log->pushHandler(new StreamHandler(dirname(__DIR__).'/logs/prod.log', Logger::INFO));
        $log->info($message,array('data' => $params));
    }

    public function sendErrorMessage($message, $params = null)
    {
        $log = new Logger('name');
        $log->pushHandler(new StreamHandler(dirname(__DIR__).'/logs/prod.log', Logger::WARNING));
        $log->error($message, ['data' => $params] );
    }
}