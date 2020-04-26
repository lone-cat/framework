<?php

namespace LoneCat\Framework\Exceptions;

use Throwable;

class ExceptionManager {

    static function init() {
        set_exception_handler([self::class, 'exceptionHandler']);
        set_error_handler([self::class, 'errorHandler']);
    }

    static function exceptionHandler($exception) {

        $message =
            ini_get('display_errors') === '1'
                ? $exception->getMessage() . ' ' . $exception->getFile() . ' ' . $exception->getLine()
                : 'Server error!';

        echo $message;

    }

    static function errorHandler($severity, $message, $file, $line) {
        $prefix = 'LoneCat\\Framework\\Exceptions\\FromErrors\\';

        $mappings = [
            E_ERROR => 'ErrorException',
            E_USER_ERROR => 'UserErrorException',
            E_RECOVERABLE_ERROR => 'RecoverableErrorException',
            E_WARNING => 'WarningException',
            E_USER_WARNING => 'UserWarningException',
            E_PARSE => 'ParseException',
            E_NOTICE => 'NoticeException',
            E_USER_NOTICE => 'UserNoticeException',
            E_CORE_ERROR => 'CoreErrorException',
            E_CORE_WARNING => 'CoreWarningException',
            E_COMPILE_ERROR => 'CompileErrorException',
            E_COMPILE_WARNING => 'CompileWarningException',
            E_STRICT => 'StrictException',
            E_DEPRECATED => 'DeprecatedException',
            E_USER_DEPRECATED => 'UserDeprecatedException',
        ];

        $exception_class =
            isset($mappings[$severity])
                ? $prefix . $mappings[$severity]
                : '\\ErrorException';

        throw new $exception_class($message, 0, $severity, $file, $line);
    }

}