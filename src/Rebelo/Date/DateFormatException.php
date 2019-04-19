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
class DateFormatException
    extends \Exception
{

    public function __construct(string $message = "", int $code = 0,
                                \Throwable $previous = NULL): \Exception
    {
        return parent::__construct($message, $code, $previous);
    }

}
