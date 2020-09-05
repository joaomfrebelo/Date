<?php

/**
 * MIT License
 *
 * Copyright (c) 2019 João M F Rebelo
 */

declare(strict_types=1);

namespace Rebelo\Date;

/**
 * DateInterval
 *
 * @author João Rebelo
 */
class DateIntervalException extends \Exception
{

    /**
     * DateIntervalException
     * @param string $message The Excption message
     * @param int $code Error code
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
