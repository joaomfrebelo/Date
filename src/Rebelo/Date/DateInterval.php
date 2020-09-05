<?php

/**
 * MIT License
 *
 * Copyright (c) 2019 João M F Rebelo
 */

declare(strict_types=1);

namespace Rebelo\Date;

/**
 * The class is the same the the PHP native DateInterval
 * but the contructor
 *  in case of excetpion will throws the \Rebelo\Date\DateIntervalException
 *
 * @author João Rebelo
 */
class DateInterval extends \DateInterval
{

    /**
     * Creates a new DateInterval object
     * <p>Creates a new DateInterval object.</p>
     * @param string $intervalSpec <p>An interval specification.</p> <p>The format starts with the letter <i>P</i>, for "period." Each duration period is represented by an integer value followed by a period designator. If the duration contains time elements, that portion of the specification is preceded by the letter <i>T</i>.</p> <p></p> <b> <code>interval_spec</code> Period Designators </b>   Period Designator Description     <i>Y</i> years   <i>M</i> months   <i>D</i> days   <i>W</i>  weeks. These get converted into days, so can not be combined with <i>D</i>.    <i>H</i> hours   <i>M</i> minutes   <i>S</i> seconds    <p>Here are some simple examples. Two days is <i>P2D</i>. Two seconds is <i>PT2S</i>. Six years and five minutes is <i>P6YT5M</i>.</p> <p><b>Note</b>:</p><p>The unit types must be entered from the largest scale unit on the left to the smallest scale unit on the right. So years before months, months before days, days before minutes, etc. Thus one year and four days must be represented as <i>P1Y4D</i>, not <i>P4D1Y</i>.</p>  <p>The specification can also be represented as a date time. A sample of one year and four days would be <i>P0001-00-04T00:00:00</i>. But the values in this format can not exceed a given period's roll-over-point (e.g. <i>25</i> hours is invalid).</p> <p>These formats are based on the ISO 8601 duration specification.</p>
     * @return self
     * @link http://php.net/manual/en/dateinterval.construct.php
     * @see DateInterval::format(), DateTime::add(), DateTime::sub(), DateTime::diff()
     * @since PHP 5 >= 5.3.0, PHP 7
     */
    public function __construct(string $intervalSpec)
    {
        try {
            parent::__construct($intervalSpec);
        } catch (\Exception $e) {
            throw new DateIntervalException(
                $e->getMessage(),
                $e->getCode(),
                $e->getPrevious()
            );
        }
    }
}
