<?php

/**
 * MIT License
 *
 * Copyright (c) 2019 João M F Rebelo
 */
declare(strict_types=1);

namespace Rebelo\Date;

/**
 * Date class
 * This class relays on the DateTime class of php but change the return type
 * for some methods and have more methods.
 * Methods like add and sub return a new Object instead of change the instance it self
 *
 * @author João Rebelo
 * @since 1.0.0
 */
class Date
{

    /**
     * @var string Atom (example: 2005-08-15T15:52:01+00:00)
     * @link http://php.net/manual/en/class.datetimeinterface.php
     * @since 1.0.0
     */
    const ATOM = "Y-m-d\TH:i:sP";

    /**
     * @var string HTTP Cookies (example: Monday, 15-Aug-2005 15:52:01 UTC)
     * @link http://php.net/manual/en/class.datetimeinterface.php
     * @since 1.0.0
     */
    const COOKIE = "l, d-M-Y H:i:s T";

    /**
     * @var string ISO-8601 (example: 2005-08-15T15:52:01+0000)  <p><b>Note</b>:
     * This format is not compatible with ISO-8601, but is left this way for backward compatibility reasons.
     * Use <b><code>DateTime::ATOM</code></b> or <b><code>DATE_ATOM</code></b>
     * for compatibility with ISO-8601 instead. </p>
     * @link http://php.net/manual/en/class.datetimeinterface.php
     * @since 1.0.0
     */
    const ISO8601 = "Y-m-d\TH:i:sO";

    /**
     * @var string RFC 822 (example: Mon, 15 Aug 05 15:52:01 +0000)
     * @link http://php.net/manual/en/class.datetimeinterface.php
     * @since 1.0.0
     */
    const RFC822 = "D, d M y H:i:s O";

    /**
     * @var string RFC 850 (example: Monday, 15-Aug-05 15:52:01 UTC)
     * @link http://php.net/manual/en/class.datetimeinterface.php
     * @since 1.0.0
     */
    const RFC850 = "l, d-M-y H:i:s T";

    /**
     * @var string RFC 1036 (example: Mon, 15 Aug 05 15:52:01 +0000)
     * @link http://php.net/manual/en/class.datetimeinterface.php
     * @since 1.0.0
     */
    const RFC1036 = "D, d M y H:i:s O";

    /**
     * @var string RFC 1123 (example: Mon, 15 Aug 2005 15:52:01 +0000)
     * @link http://php.net/manual/en/class.datetimeinterface.php
     * @since 1.0.0
     */
    const RFC1123 = "D, d M Y H:i:s O";

    /**
     * @var string RFC 2822 (example: Mon, 15 Aug 2005 15:52:01 +0000)
     * @link http://php.net/manual/en/class.datetimeinterface.php
     * @since 1.0.0
     */
    const RFC2822 = "D, d M Y H:i:s O";

    /**
     * @var string Same as <b><code>DATE_ATOM</code></b> (since PHP 5.1.3)
     * @link http://php.net/manual/en/class.datetimeinterface.php
     * @since 1.0.0
     */
    const RFC3339 = "Y-m-d\TH:i:sP";

    /**
     * @var string RFC 3339 EXTENDED format (since PHP 7.0.0) (example: 2005-08-15T15:52:01.000+00:00)
     * @link http://php.net/manual/en/class.datetimeinterface.php
     * @since 1.0.0
     */
    const RFC3339_EXTENDED = "Y-m-d\TH:i:s.vP";

    /**
     * @var string RSS (example: Mon, 15 Aug 2005 15:52:01 +0000)
     * @link http://php.net/manual/en/class.datetimeinterface.php
     * @since 1.0.0
     */
    const RSS = "D, d M Y H:i:s O";

    /**
     * @var string World Wide Web Consortium (example: 2005-08-15T15:52:01+00:00)
     * @link http://php.net/manual/en/class.datetimeinterface.php
     * @since 1.0.0
     */
    const W3C = "Y-m-d\TH:i:sP";

    /**
     * @var string SQL Date (Example: 1969-10-05)
     * @since 1.0.0
     */
    const SQL_DATE = "Y-m-d";

    /**
     *
     * Date time combined with thw T char
     *
     * Ex: 1969-10-05T09:29:39
     *
     * @var string
     * @since 2.1.0
     */
    const DATE_T_TIME = "Y-m-d\TH:i:s";

    /**
     * Date and time
     * Ex: 1969-10-05 09:29:39
     *
     * @var string
     * @since 2.1.0
     */
    const DATE_TIME = "Y-m-d H:i:s";

    /**
     * @var string SQL DateTime (Example: 1969-10-05 09:00:00)
     * @since 1.0.0
     */
    const SQL_DATETIME = "Y-m-d H:i:s";

    /**
     * Day of the month, 2 digits with leading zeros
     * Exmaple 01 or 31
     *
     * @var string
     * @since 1.0.0
     */
    const DAY = "d";

    /**
     * Day of the month, 1 or 2 digits without leading zeros
     * Exmaple 1 or 31
     *
     * @var string
     * @since 1.0.0
     */
    const DAY_LESS = "d";

    /**
     * A textual representation of a day
     * Mon through Sun
     *
     * @var string
     * @since 1.0.0
     */
    const DAY_TEXT_SHORT = "D";

    /**
     * A textual representation of a day
     * Sunday through Saturday
     * @var string
     * @since 1.0.0
     */
    const DAY_TEXT = "l";

    /**
     * English ordinal suffix for the day of the month, 2 characters.
     * It's ignored while processing.
     * Example: st, nd, rd or th.
     *
     * @var string
     * @since 1.0.0
     */
    const ENGLISH_SUFIX = "S";

    /**
     * The day of the year (starting from 0)
     * 0 through 365
     *
     * @var string
     * @since 1.0.0
     */
    const DAY_OF_YAER = "z";

    /**
     * A textual representation of a month, such as January
     * January through December
     * @var string
     * @since 1.0.0
     */
    const MONTH_TEXT = "F";

    /**
     * A textual representation of a month, such as Sept
     * Jan through Dec
     * @var string
     * @since 1.0.0
     */
    const MONTH_TEXT_SHORT = "M";

    /**
     * Numeric representation of a month, with leading zeros
     * 01 through 12
     * @var string
     * @since 1.0.0
     */
    const MONTH = "m";

    /**
     * Numeric representation of a month, without leading zeros
     * 1 through 12
     * @var string
     * @since 1.0.0
     */
    const MONTH_SHORT = "n";

    /**
     * A full numeric representation of a year, 4 digits
     * Examples: 1999 or 2003
     *
     * @var string
     * @since 1.0.0
     */
    const YAER = "Y";

    /**
     * A two digit representation of a year
     * (which is assumed to be in the range 1970-2069, inclusive)
     *
     * Examples: 99 or 03 (which will be interpreted as 1999 and 2003, respectively)
     *
     * @var string
     * @since 1.0.0
     */
    const YEAR_SHORT = "y";

    /**
     * Ante meridiem
     * time am (before 12:00)
     * @var string
     * @since 1.0.0
     */
    const ANTE_MERIDIEM = "a";

    /**
     * Post meridiem
     * time pm (after 12:00)
     * @var string
     * @since 1.0.0
     */
    const POST_MERIDIEM = "A";

    /**
     * 12-hour format of an hour with leading zero
     *
     * @var string
     * @since 1.0.0
     */
    const HOUR_12 = "h";

    /**
     * 12-hour format of an hour without leading zero
     *
     * @var string
     * @since 1.0.0
     */
    const HOUR_12_SHORT = "g";

    /**
     * 24-hour format of an hour with leading zero
     *
     * @var string
     * @since 1.0.0
     */
    const HOUR_24 = "H";

    /**
     * 24-hour format of an hour without leading zero
     *
     * @var string
     * @since 1.0.0
     */
    const HOUR_24_SHORT = "G";

    /**
     * Minutes with leading zeros
     * 00 to 59
     *
     * @var string
     * @since 1.0.0
     */
    const MINUTES = "i";

    /**
     * Seconds with leading zeros
     * 00 to 59
     *
     * @var string
     * @since 1.0.0
     */
    const SECONDS = "s";

    /**
     * Microseconds up to six digits
     *
     * @var string
     * @since 1.0.0
     */
    const MICRO_SECONDS = "u";

    /**
     * Microseconds up to 3 digits
     *
     * @var string
     * @since 1.0.0
     */
    const MICRO_SEC_SHORT = "v";

    /**
     *
     * Seconds since the Unix Epoch (January 1 1970 00:00:00 GMT)
     *
     * @var string
     * @since 1.0.0
     */
    const UNIX_TIMESTAMP = "U";

    /**
     * Time Ex: 09:59:29
     *
     * @var string
     * @since 1.0.0
     */
    const TIME = "H:i:s";

    /**
     * Time with up 3 digits in microseconds Ex: 09:59:29.999
     *
     * @var string
     * @since 1.0.0
     */
    const TIME_MICRO_SECONDS = "H:i:s.v";

    /**
     * Time with up 6 digits in microseconds Ex: 09:59:29.000999
     *
     * @var string
     * @since 1.0.0
     */
    const TIME_MICRO_L_SECONDS = "H:i:s.u";

    /**
     * The base object
     * @var \DateTime
     * @since 1.0.0
     */
    protected \DateTime $date;

    public function __construct(string $time = "now",
                                \DateTimeZone $timezone = NULL)
    {
        $this->date = new \DateTime($time, $timezone);
    }

    /**
     *
     * Create a Date object from a string
     *
     * The format is one of the use in PHP \DateTime
     * If the Date is not valide it will throws \Rebelo\Date\DateParseException
     *
     * @param string $format
     * @param string $time
     * @param \DateTimeZone|null $timezone
     * @return \Rebelo\Date\Date
     * @throws DateParseException
     * @since 1.0.0
     */
    public static function parse(string $format, string $time,
                                 ?\DateTimeZone $timezone = null): \Rebelo\Date\Date
    {
        $dateTime = \DateTime::createFromFormat($format, $time, $timezone);
        $errors   = \DateTime::getLastErrors();
        if ($errors['warning_count'] !== 0 || $errors['error_count'] !== 0)
        {
            $array = array();
            if (array_key_exists("warnings", $errors))
            {
                $array = array_merge($array, $errors["warnings"]);
            }
            if (array_key_exists("errors", $errors))
            {
                $array = array_merge($array, $errors["errors"]);
            }
            throw new DateParseException("While parsing date: "
                . join("; ", $array));
        }
        $date       = new Date();
        $date->date = $dateTime;
        return $date;
    }

    /**
     * Alias of Date::parse
     *
     * @param string $format
     * @param string $time
     * @param \DateTimeZone|null $timezone
     * @return \Rebelo\Date\Date
     * @since 1.0.0
     */
    public static function createFromFormat(string $format, string $time,
                                            ?\DateTimeZone $timezone = null): \Rebelo\Date\Date
    {
        return static::parse($format, $time, $timezone);
    }

    /**
     * Returns date formatted according to given format
     * <p>Returns date formatted according to given format.</p>
     *
     * @param string $format <p>Format accepted by <code>date()</code>.</p>
     * @return string
     * @throws DateFormatException
     * @since 1.0.0
     */
    public function format(string $format): string
    {
        $str = $this->date->format($format);
        if ($str === false)
        {
            throw new DateFormatException("Error formating date");
        }
        return $str;
    }

    /**
     *
     * Return a new DateTime that is this DateTime plus the DateInterval.
     * This date value is not changed, the result is a new instance
     *
     * @param \Rebelo\Date\DateInterval $interval
     * @return \Rebelo\Date\Date
     * @since 1.0.0
     */
    public function add(\Rebelo\Date\DateInterval $interval): \Rebelo\Date\Date
    {
        $addDate = clone $this->date;
        $res     = $addDate->add($interval);
        if ($res === false)
        {
            throw new DateException("Error on adding the interval");
        }
        return Date::createFromFormat("Y-m-d\TH:i:s.u",
                                      $res->format("Y-m-d\TH:i:s.u"),
                                                   $res->getTimezone());
    }

    /**
     * Retrun a new Date that as the result of subtract to this the interval
     * This Date value is not chenged, the result is a new instance
     * @param \Rebelo\Date\DateInterval $interval
     * @return \Rebelo\Date\Date
     * @throws DateException
     * @since 1.0.0
     */
    public function sub(\Rebelo\Date\DateInterval $interval): \Rebelo\Date\Date
    {
        $subDate = clone $this->date;
        $res     = $subDate->sub($interval);
        if ($res === false)
        {
            throw new DateException("Erros subtrating interval");
        }
        return Date::createFromFormat("Y-m-d\TH:i:s.u",
                                      $res->format("Y-m-d\TH:i:s.u"),
                                                   $res->getTimezone());
    }

    /**
     *
     * Returns the difference between two DateTime objects
     *
     * @param \Rebelo\Date\Date $datetime2
     * @param bool $absolute <p>Should the interval be forced to be positive&#63;</p>
     * @return \DateInterval
     * @since 1.0.0
     */
    public function diff(\Rebelo\Date\Date $datetime2, bool $absolute = false): \DateInterval
    {
        return $this->date->diff($datetime2->date, $absolute);
    }

    /**
     * Returns the timezone offset
     * @return int
     * @since 1.0.0
     */
    public function getOffset(): int
    {
        return $this->date->getOffset();
    }

    /**
     * Gets the Unix timestamp
     *
     * @return int
     * @since 1.0.0
     */
    public function getTimestamp(): int
    {
        return $this->date->getTimestamp();
    }

    /**
     * Return time zone relative
     * @return \DateTimeZone
     * @since 1.0.0
     */
    public function getTimezone(): \DateTimeZone
    {
        return $this->date->getTimezone();
    }

    /**
     * Alters the timestamp of this Date
     *
     * @link  http://php.net/manual/en/datetime.modify.php Accept formats
     * @param string $modify
     * @return \Rebelo\Date\Date
     * @since 1.0.0
     */
    public function modify(string $modify): \Rebelo\Date\Date
    {

        if ($this->date->modify($modify) === false)
        {
            throw new DateException("Filed to modify timestamp in " . __METHOD__ .
                " for string '$modify'");
        }
        return $this;
    }

    /**
     * Sets the date
     * <p>Resets the current date of the DateTime object to a different date.</p>
     * @param int $year
     * @param int $month
     * @param int $day
     * @return \Rebelo\Date\Date
     * @since 1.0.0
     */
    public function setDate(int $year, int $month, int $day): \Rebelo\Date\Date
    {
        $format = static::YAER . "-" . static::MONTH_SHORT . "-" . static::DAY_LESS;
        $date   = ((string) $year) . "-" . ((string) $month) . "-" . ((string) $day);
        static::parse($format, $date); // To test if the date is valide, other wise throws exception

        if ($this->date->setDate($year, $month, $day) === false)
        {
            throw new DateException("Wrong date to set");
        }
        return $this;
    }

    /**
     * Set the year of this date object
     * @param int $year
     * @return \Rebelo\Date\Date $this
     * @since 1.0.0
     */
    public function setYaer(int $year): \Rebelo\Date\Date
    {
        $month = intval($this->format(static::MONTH));
        $day   = intval($this->format(static::DAY_LESS));
        $this->setDate($year, $month, $day);
        return $this;
    }

    /**
     * Set the month of this date object
     * @param int $month
     * @return \Rebelo\Date\Date $this
     * @since 1.0.0
     */
    public function setMonth(int $month): \Rebelo\Date\Date
    {
        $year = intval($this->format(static::YAER));
        $day  = intval($this->format(static::DAY_LESS));
        $this->setDate($year, $month, $day);
        return $this;
    }

    /**
     * Set the day of month of this date object
     * @param int $day
     * @return \Rebelo\Date\Date $this
     * @since 1.0.0
     */
    public function setDay(int $day): \Rebelo\Date\Date
    {
        $year  = intval($this->format(static::YAER));
        $month = intval($this->format(static::MONTH_SHORT));
        $this->setDate($year, $month, $day);
        return $this;
    }

    /**
     * Sets the ISO date
     * <p>Set a date according to the ISO 8601 standard
     * - using weeks and day offsets rather than specific dates.</p>
     *
     * @param int $year
     * @param int $week
     * @param int $day
     * @return \Rebelo\Date\Date
     * @since 1.0.0
     */
    public function setISODate(int $year, int $week, int $day = 1): \Rebelo\Date\Date
    {
        $this->date->setISODate($year, $week, $day);
        return $this;
    }

    /**
     * Sets the time
     * <p>Resets the current time of the DateTime object to a different time.</p>
     * @param int $hour
     * @param int $minute
     * @param int $second
     * @param int $microseconds
     * @return \Rebelo\Date\Date
     * @since 1.0.0
     */
    public function setTime(int $hour, int $minute, int $second = 0,
                            int $microseconds = 0): \Rebelo\Date\Date
    {
        if ($hour < 0 || $hour > 23)
        {
            throw new DateException("Worng hour '$hour'");
        }

        if ($minute < 0 || $minute > 59)
        {
            throw new DateException("Worng minutes '$minute'");
        }

        if ($second < 0 || $second > 59)
        {
            throw new DateException("Worng minutes '$minute'");
        }

        if ($microseconds < 0 || $microseconds > 999999)
        {
            throw new DateException("Worng microseconds '$microseconds'");
        }

        $this->date->setTime($hour, $minute, $second, $microseconds);
        return $this;
    }

    /**
     *
     * Set the hour of this Date object
     *
     * @param int $hour
     * @return \Rebelo\Date\Date $this
     * @since 1.0.0
     */
    public function setHour(int $hour): \Rebelo\Date\Date
    {
        $minute  = intval($this->format(static::MINUTES));
        $seconds = intval($this->format(static::SECONDS));
        $micro   = intval($this->format(static::MICRO_SECONDS));
        $this->setTime($hour, $minute, $seconds, $micro);
        return $this;
    }

    /**
     *
     * Set the minutes of this Date object
     *
     * @param int $minute
     * @return \Rebelo\Date\Date $this
     * @since 1.0.0
     */
    public function setMinutes(int $minute): \Rebelo\Date\Date
    {
        $hour    = intval($this->format(static::HOUR_24_SHORT));
        $seconds = intval($this->format(static::SECONDS));
        $micro   = intval($this->format(static::MICRO_SECONDS));
        $this->setTime($hour, $minute, $seconds, $micro);
        return $this;
    }

    /**
     *
     * Set the seconds of this Date object
     *
     * @param int $seconds
     * @return \Rebelo\Date\Date $this
     * @since 1.0.0
     */
    public function setSeconds(int $seconds): \Rebelo\Date\Date
    {
        $hour   = intval($this->format(static::HOUR_24_SHORT));
        $minute = intval($this->format(static::MINUTES));
        $micro  = intval($this->format(static::MICRO_SECONDS));
        $this->setTime($hour, $minute, $seconds, $micro);
        return $this;
    }

    /**
     *
     * Set the microseconds of this Date object
     *
     * @param int $microseconds
     * @return \Rebelo\Date\Date $this
     * @since 1.0.0
     */
    public function setMicroseconds(int $microseconds): \Rebelo\Date\Date
    {
        $hour    = intval($this->format(static::HOUR_24_SHORT));
        $minute  = intval($this->format(static::MINUTES));
        $seconds = intval($this->format(static::SECONDS));
        $this->setTime($hour, $minute, $seconds, $microseconds);
        return $this;
    }

    /**
     * Set the Timestamp of this date
     * @param int $unixtimestamp
     * @return \Rebelo\Date\Date
     * @since 1.0.0
     */
    public function setTimestamp(int $unixtimestamp): \Rebelo\Date\Date
    {
        $this->date->setTimestamp($unixtimestamp);
        return $this;
    }

    /**
     *
     * Set the time zone of this date
     *
     * @param \DateTimeZone $timezone
     * @return \Rebelo\Date\Date
     * @since 1.0.0
     */
    public function setTimezone(\DateTimeZone $timezone): \Rebelo\Date\Date
    {
        $this->date->setTimezone($timezone);
        return $this;
    }

    /**
     * Return a new Date object that is this add with the number of years
     * To subtract the $years must be negative
     *
     * @param int $years Number of years to add or negative integer to subtract
     * @return \Rebelo\Date\Date
     * @throws DateException
     * @since 1.0.0
     */
    public function addYears(int $years): \Rebelo\Date\Date
    {
        if ($years < 0)
        {
            return $this->sub(new \Rebelo\Date\DateInterval("P" . ((string) \abs($years)) . "Y"));
        }
        return $this->add(new \Rebelo\Date\DateInterval("P" . ((string) $years) . "Y"));
    }

    /**
     * Return a new Date object that is this add with the number of months
     * To subtract the $months must be negative
     *
     * @param int $months Number of months to add or negative integer to subtract
     * @return \Rebelo\Date\Date
     * @since 1.0.0
     */
    public function addMonths(int $months): \Rebelo\Date\Date
    {
        if ($months < 0)
        {
            return $this->sub(new \Rebelo\Date\DateInterval("P" . ((string) \abs($months)) . "M"));
        }
        return $this->add(new \Rebelo\Date\DateInterval("P" . ((string) $months) . "M"));
    }

    /**
     * Return a new Date object that is this Date add with the number of days
     * To subtract the $days must be negative integer
     *
     * @param int $days Number of days to add or negative integer to subtract
     * @return \Rebelo\Date\Date
     * @since 1.0.0
     */
    public function addDays(int $days): \Rebelo\Date\Date
    {
        if ($days < 0)
        {
            return $this->sub(new \Rebelo\Date\DateInterval("P" . ((string) \abs($days)) . "D"));
        }
        return $this->add(new \Rebelo\Date\DateInterval("P" . ((string) $days) . "D"));
    }

    /**
     * Return a new Date object that is this add with the number of hours
     * To subtract the $hours must be negative integer
     *
     * @param int $hours Number of hours to add or negative integer to subtract
     * @return \Rebelo\Date\Date
     * @since 1.0.0
     */
    public function addHours(int $hours): \Rebelo\Date\Date
    {
        if ($hours < 0)
        {
            return $this->sub(new \Rebelo\Date\DateInterval("PT" . ((string) \abs($hours)) . "H"));
        }
        return $this->add(new \Rebelo\Date\DateInterval("PT" . ((string) $hours) . "H"));
    }

    /**
     * Return a new Date object that is this add with the number of minutes
     * To subtract the $minutes must be negative integer
     *
     * @param int $minutes Number of minutes to add or negative integer to subtract
     * @return \Rebelo\Date\Date
     * @since 1.0.0
     */
    public function addMinutes(int $minutes): \Rebelo\Date\Date
    {
        if ($minutes < 0)
        {
            return $this->sub(new \Rebelo\Date\DateInterval("PT" . ((string) \abs($minutes)) . "M"));
        }
        return $this->add(new \Rebelo\Date\DateInterval("PT" . ((string) $minutes) . "M"));
    }

    /**
     * Return a new Date object that is this add with the number of seconds
     * To subtract the $seconds must be negative integer
     *
     * @param int $seconds
     * @return \Rebelo\Date\Date
     * @since 1.0.0
     */
    public function addSeconds(int $seconds): \Rebelo\Date\Date
    {
        if ($seconds < 0)
        {
            return $this->sub(new \Rebelo\Date\DateInterval("PT" . ((string) \abs($seconds)) . "S"));
        }
        return $this->add(new \Rebelo\Date\DateInterval("PT" . ((string) $seconds) . "S"));
    }

    /**
     *
     * Returne the native PHP DateTime class
     *
     * @return \DateTime
     * @since 1.0.0
     */
    public function toDateTime(): \DateTime
    {
        return $this->date;
    }

    /**
     * @return
     * @since 2.0.0
     */
    public function __clone()
    {
        $this->date = clone $this->date;
    }

}
