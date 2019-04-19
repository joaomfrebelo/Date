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
class DateIntervalException
    extends \Exception
{

    public function __construct(string $message = "", int $code = 0,
                                \Throwable $previous = NULL)
    {
        return parent::__construct($message, $code, $previous);
    }

}
