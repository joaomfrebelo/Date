<?php

/**
 * MIT License
 *
 * Copyright (c) 2019 João M F Rebelo
 */

declare(strict_types=1);

namespace Rebelo\Date;

/**
 * DateFormatException
 *
 * @author João Rebelo
 */
class DateFormatException extends \Exception
{

    /**
     * DateFormatException
     * @param string $message The Exception message
     * @param int $code The error code
     * @param \Throwable $previous The previous exception used for the exception chaining.
     */
    public function __construct(
        string $message = "",
        int $code = 0,
        \Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
    }
}
