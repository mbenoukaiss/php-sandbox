<?php

function getReportedErrors(): array {
    $errorReporting = error_reporting();
    $errors = [];

    if($errorReporting === E_ALL) {
        $errors[] = "E_ALL";
    } else {
        for ($i = 0; $i < 15; $i++) {
            $error = match ($errorReporting & pow(2, $i)) {
                E_ERROR             => 'E_ERROR',
                E_WARNING           => 'E_WARNING',
                E_PARSE             => 'E_PARSE',
                E_NOTICE            => 'E_NOTICE',
                E_CORE_ERROR        => 'E_CORE_ERROR',
                E_CORE_WARNING      => 'E_CORE_WARNING',
                E_COMPILE_ERROR     => 'E_COMPILE_ERROR',
                E_COMPILE_WARNING   => 'E_COMPILE_WARNING',
                E_USER_ERROR        => 'E_USER_ERROR',
                E_USER_WARNING      => 'E_USER_WARNING',
                E_USER_NOTICE       => 'E_USER_NOTICE',
                E_STRICT            => 'E_STRICT',
                E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR',
                E_DEPRECATED        => 'E_DEPRECATED',
                E_USER_DEPRECATED   => 'E_USER_DEPRECATED',
                default             => null,
            };

            if ($error) {
                $errors[] = $error;
            }
        }
    }

    return $errors;
}