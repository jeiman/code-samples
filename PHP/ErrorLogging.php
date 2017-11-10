<?php
// set_trigger_error only accepts E_USER_ constants values
define('ERROR', 256);   // Before E_USER_ERROR
define('INFO',  512);   // Before E_USER_WARNING
define('DEBUG', 1024);  // Before E_USER_NOTICE

function errorHandler ($errType, $errStr, $errFile = '', $errLine, $errContext) {
    $displayErrors = ini_get( 'display_errors' );
    $logErrors     = ini_get( 'log_errors' );
    $errorLog      = ini_get( 'error_log' );

    if( $displayErrors ) echo $errStr.PHP_EOL;

    if( $logErrors ) {
        $line = "";
        switch ($errType) {
            case DEBUG:
                $type = 'DEBUG';
                break;
            case INFO:
                $type = 'INFO';
                break;
            case ERROR:
                $type = 'ERROR';
                $line = " (Line:".$errLine.")";
                break;
            default:
                $type = 'WARN';
                $line = " (Line:".$errLine.")";
                break;
        }
        $message = date('Y-m-d H:i:sO').";".$type.";".$errStr.$line;
        file_put_contents($errorLog, $message.PHP_EOL, FILE_APPEND);
    }
}

set_error_handler('errorHandler');

error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', '../logs/test.log');