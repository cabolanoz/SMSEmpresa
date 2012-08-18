<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'KLogger.php';

class Logger {

    public static function info($message, $filename = '/var/log/  ') {

        $log = new KLogger(dirname(__FILE__), KLogger::DEBUG);
        $log->logInfo($message);
    }

}

?>