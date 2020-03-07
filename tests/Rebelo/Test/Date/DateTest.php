<?php

/**
 * MIT License
 *
 * Copyright (c) 2019 João M F Rebelo
 */
declare(strict_types=1);

namespace Rebelo\Test\Date;

require_once __DIR__ . '/CommnunTest.php';

use Rebelo\Date\Date;

/**
 * tests of \Rebelo\Date\Date class
 *
 * @author João Rebelo
 */
class DateTest
    extends \PHPUnit\Framework\TestCase
{

    public function testReflection()
    {
        (new \Rebelo\Test\CommnunTest())->testReflection(\Rebelo\Date\Date::class);
    }

    /**
     *
     * @var \Rebelo\Date\Date
     */
    static $d4ope;

    public function testInstance()
    {
        $date = new \Rebelo\Date\Date();
        $this->assertInstanceOf(\Rebelo\Date\Date::class, $date);
    }

    /**
     * @depends testInstance
     */
    public function testParse()
    {
        $date = \Rebelo\Date\Date::createFromFormat(Date::SQL_DATETIME,
                                                    "1969-10-05 09:00:00",
                                                    new \DateTimeZone("Europe/Lisbon")
        );
        $this->assertInstanceOf(\Rebelo\Date\Date::class, $date);

        static::$d4ope = $date;
    }

    public function testParseDayNotExist()
    {
        $this->expectException(\Rebelo\Date\DateParseException::class);
        \Rebelo\Date\Date::createFromFormat(Date::SQL_DATE, "1969-04-31");
    }

    public function testParseWrongFormat()
    {
        $this->expectException(\Rebelo\Date\DateParseException::class);
        \Rebelo\Date\Date::createFromFormat(Date::SQL_DATE, "1969-31");
    }

    /**
     * @depends testParse
     */
    public function testCreateFromFormat()
    {
        $date = \Rebelo\Date\Date::createFromFormat(Date::SQL_DATE, "1969-10-05");
        $this->assertInstanceOf(\Rebelo\Date\Date::class, $date);
    }

    /**
     * @depends testParse
     */
    public function testFormat()
    {
        $date = \Rebelo\Date\Date::createFromFormat(Date::SQL_DATE, "1969-10-05");
        $this->assertEquals("1969-10-05", $date->format(Date::SQL_DATE));
    }

    /**
     * @depends testParse
     * @depends testFormat
     */
    public function testAdd()
    {
        $date = \Rebelo\Date\Date::parse(Date::SQL_DATE, "1969-10-05");
        $add  = $date->add(new \Rebelo\Date\DateInterval("P1Y"));
        $this->assertEquals("1969-10-05", $date->format(Date::SQL_DATE));
        $this->assertEquals("1970-10-05", $add->format(Date::SQL_DATE));
    }

    /**
     * @depends testParse
     * @depends testFormat
     */
    public function testSub()
    {
        $date = \Rebelo\Date\Date::parse(Date::SQL_DATE, "1969-10-05");
        $add  = $date->sub(new \Rebelo\Date\DateInterval("P9Y"));
        $this->assertEquals("1969-10-05", $date->format(Date::SQL_DATE));
        $this->assertEquals("1960-10-05", $add->format(Date::SQL_DATE));
    }

    /**
     * @depends testParse
     * @depends testFormat
     */
    public function testDiff()
    {
        $date1 = \Rebelo\Date\Date::parse(Date::SQL_DATE, "1969-10-05");
        $date2 = \Rebelo\Date\Date::parse(Date::SQL_DATE, "2019-10-05");
        $diff  = $date1->diff($date2, false);
        $this->assertEquals(0, $diff->invert);
        $this->assertEquals(50, $diff->y);

        $date3 = \Rebelo\Date\Date::parse(Date::SQL_DATE, "1979-10-05");
        $date4 = \Rebelo\Date\Date::parse(Date::SQL_DATE, "1969-10-05");
        $diff2 = $date3->diff($date4, false);
        $this->assertEquals(1, $diff2->invert);
        $this->assertEquals(10, $diff2->y);
    }

    /**
     * @depends testParse
     */
    public function testOffset()
    {
        $date = \Rebelo\Date\Date::parse(Date::SQL_DATE, "1969-10-05",
                                         new \DateTimeZone("Europe/Lisbon"));
        $this->assertEquals(3600, $date->getOffset());
    }

    /**
     * @depends testParse
     */
    public function testTimestamp()
    {
        $date = \Rebelo\Date\Date::parse(Date::SQL_DATETIME
                , "2019-10-05 09:00:00", new \DateTimeZone("Europe/Lisbon"));
        $this->assertEquals(1570262400, $date->getTimestamp());
    }

    /**
     * @depends testParse
     */
    public function testTimeszone()
    {
        $date = \Rebelo\Date\Date::parse(Date::SQL_DATETIME
                , "2019-10-05 09:00:00", new \DateTimeZone("Europe/Lisbon"));
        $this->assertEquals("Europe/Lisbon", $date->getTimezone()->getName());
    }

    /**
     * @depends testParse
     */
    public function testModify()
    {
        $date = \Rebelo\Date\Date::parse(Date::SQL_DATETIME
                , "1969-10-05 09:00:00", new \DateTimeZone("Europe/Lisbon"));
        $this->assertEquals("1969-10-05 09:00:00",
                            $date->format(Date::SQL_DATETIME));
        $date->modify("+50 year");
        $this->assertEquals("2019-10-05 09:00:00",
                            $date->format(Date::SQL_DATETIME));
    }

// Bug on PHP DateTime modify method does not return false
//    /**
//     * @depends testParse
//     */
//    public function testModifyException()
//    {
//        $date = \Rebelo\Date\Date::parse(Date::SQL_DATETIME
//                , "1969-10-05 09:00:00", new \DateTimeZone("Europe/Lisbon"));
//        $this->expectException(\Rebelo\Date\DateException::class);
//        $date->modify("+50 xx");
//    }

    /**
     * @depends testInstance
     * @depends testFormat
     */
    public function testSetDate()
    {
        $date = new \Rebelo\Date\Date();
        //Set the date and return the self instance
        $this->assertInstanceOf(\Rebelo\Date\Date::class,
                                $date->setDate(1969, 10, 5));
        $this->assertEquals("1969-10-05",
                            $date->format(\Rebelo\Date\Date::SQL_DATE));
    }

    /**
     * @depends testInstance
     * @depends testFormat
     * @depends testSetDate
     */
    public function testSetYear()
    {
        $date = new \Rebelo\Date\Date();
        //Set the year and return the self instance
        $this->assertInstanceOf(\Rebelo\Date\Date::class, $date->setYaer(1969));
        $this->assertEquals(1969, $date->format(\Rebelo\Date\Date::YAER));
    }

    /**
     * @depends testInstance
     * @depends testFormat
     * @depends testSetDate
     * @depends testParse
     */
    public function testSetMonth()
    {
        $date = \Rebelo\Date\Date::parse(\Rebelo\Date\Date::SQL_DATE,
                                         "1969-10-05");
        //Set the month and return the self instance
        $this->assertInstanceOf(\Rebelo\Date\Date::class, $date->setMonth(9));
        $this->assertEquals(9, $date->format(\Rebelo\Date\Date::MONTH_SHORT));
    }

    /**
     * @depends testInstance
     * @depends testFormat
     * @depends testSetDate
     * @depends testParse
     */
    public function testSetDay()
    {
        $date = \Rebelo\Date\Date::parse(\Rebelo\Date\Date::SQL_DATE,
                                         "1969-10-05");
        //Set the month and return the self instance
        $this->assertInstanceOf(\Rebelo\Date\Date::class, $date->setDay(9));
        $this->assertEquals(9, $date->format(\Rebelo\Date\Date::DAY_LESS));
    }

    /**
     * @depends testInstance
     * @depends testFormat
     */
    public function testExceptiontMonthSetDate()
    {
        $date = new \Rebelo\Date\Date();
        $this->expectException(\Rebelo\Date\DateParseException::class);
        $date->setDate(1999, 99, 5);
    }

    /**
     * @depends testInstance
     * @depends testFormat
     */
    public function testExceptiontDaySetDate()
    {
        $date = new \Rebelo\Date\Date();
        $this->expectException(\Rebelo\Date\DateParseException::class);
        $date->setDate(1999, 10, 50);
    }

    /**
     * @depends testInstance
     * @depends testFormat
     */
    public function testSetIsoDate()
    {
        $date = new \Rebelo\Date\Date();
        $date->setISODate(2008, 2, 7);
        $this->assertEquals("2008-01-13",
                            $date->format(\Rebelo\Date\Date::SQL_DATE));
    }

    /**
     * @depends testInstance
     * @depends testFormat
     */
    public function testSetTime()
    {
        $date = new \Rebelo\Date\Date();
        //Set the time and return the self instance
        $this->assertInstanceOf(\Rebelo\Date\Date::class,
                                $date->setTime(9, 29, 59, 102999));
        $this->assertEquals("09:29:59", $date->format(\Rebelo\Date\Date::TIME));
        $this->assertEquals("09:29:59.102",
                            $date->format(\Rebelo\Date\Date::TIME_MICRO_SECONDS));
        $this->assertEquals("09:29:59.102999",
                            $date->format(\Rebelo\Date\Date::TIME_MICRO_L_SECONDS));
    }

    /**
     * @depends testInstance
     * @depends testFormat
     */
    public function testSetTimeExcptionHourGrater()
    {
        $date = new \Rebelo\Date\Date();
        $this->expectException(\Rebelo\Date\DateException::class);
        $date->setTime(25, 0);
    }

    /**
     * @depends testInstance
     * @depends testFormat
     */
    public function testSetTimeExcptionHourLower()
    {
        $date = new \Rebelo\Date\Date();
        $this->expectException(\Rebelo\Date\DateException::class);
        $date->setTime(-1, 0);
    }

    /**
     * @depends testInstance
     * @depends testFormat
     */
    public function testSetTimeExcptionMinuteGrater()
    {
        $date = new \Rebelo\Date\Date();
        $this->expectException(\Rebelo\Date\DateException::class);
        $date->setTime(0, 60);
    }

    /**
     * @depends testInstance
     * @depends testFormat
     */
    public function testSetTimeExcptionMinuteLower()
    {
        $date = new \Rebelo\Date\Date();
        $this->expectException(\Rebelo\Date\DateException::class);
        $date->setTime(0, -1);
    }

    /**
     * @depends testInstance
     * @depends testFormat
     */
    public function testSetTimeExcptionSecondGrater()
    {
        $date = new \Rebelo\Date\Date();
        $this->expectException(\Rebelo\Date\DateException::class);
        $date->setTime(0, 0, 60);
    }

    /**
     * @depends testInstance
     * @depends testFormat
     */
    public function testSetTimeExcptionSecondLower()
    {
        $date = new \Rebelo\Date\Date();
        $this->expectException(\Rebelo\Date\DateException::class);
        $date->setTime(0, 0, -1);
    }

    /**
     * @depends testInstance
     * @depends testFormat
     */
    public function testSetTimeExcptionMicroGrater()
    {
        $date = new \Rebelo\Date\Date();
        $this->expectException(\Rebelo\Date\DateException::class);
        $date->setTime(0, 0, 0, 1000000);
    }

    /**
     * @depends testInstance
     * @depends testFormat
     * @depends testSetTime
     */
    public function testSetHour()
    {
        $date = new \Rebelo\Date\Date();
        $date->setTime(9, 29, 59, 102999);
        //Set the hour and return the self instance
        $this->assertInstanceOf(\Rebelo\Date\Date::class, $date->setHour(19));
        $this->assertEquals("19:29:59", $date->format(\Rebelo\Date\Date::TIME));
    }

    /**
     * @depends testInstance
     * @depends testFormat
     * @depends testSetTime
     */
    public function testSetMinutes()
    {
        $date = new \Rebelo\Date\Date();
        $date->setTime(9, 29, 59, 102999);
        // Set minutes and return the self instnce
        $this->assertInstanceOf(\Rebelo\Date\Date::class, $date->setMinutes(49));
        $this->assertEquals("09:49:59", $date->format(\Rebelo\Date\Date::TIME));
    }

    /**
     * @depends testInstance
     * @depends testFormat
     * @depends testSetTime
     */
    public function testSetSeconds()
    {
        $date = new \Rebelo\Date\Date();
        $date->setTime(9, 29, 59, 102999);
        //Set seconds and return the self instance
        $this->assertInstanceOf(\Rebelo\Date\Date::class, $date->setSeconds(39));
        $this->assertEquals("09:29:39", $date->format(\Rebelo\Date\Date::TIME));
    }

    /**
     * @depends testInstance
     * @depends testFormat
     * @depends testSetTime
     */
    public function testSetMicroseconds()
    {
        $date = new \Rebelo\Date\Date();
        //Set microseconds and return the self instance
        $this->assertInstanceOf(\Rebelo\Date\Date::class,
                                $date->setTime(9, 29, 59, 102999));
        $date->setMicroseconds(999425);
        $this->assertEquals(999425,
                            $date->format(\Rebelo\Date\Date::MICRO_SECONDS));
    }

    /**
     * @depends testInstance
     * @depends testFormat
     */
    public function testSetTimeExcptionMicroLower()
    {
        $date = new \Rebelo\Date\Date();
        $this->expectException(\Rebelo\Date\DateException::class);
        $date->setTime(0, 0, 0, 1000000);
    }

    /**
     * @depends testParse
     * @depends testFormat
     */
    public function testSetTimeStamp()
    {
        $date = \Rebelo\Date\Date::parse(Date::SQL_DATETIME
                , "2000-10-05 09:09:59", new \DateTimeZone("Europe/Lisbon"));
        $date->setTimestamp(1570262400);
        $this->assertEquals("2019-10-05 09:00:00",
                            $date->format(Date::SQL_DATETIME));
    }

    /**
     * @depends testInstance
     */
    public function testSetTimeZone()
    {
        $date = new \Rebelo\Date\Date();
        $date->setTimezone(new \DateTimeZone("Europe/Lisbon"));
        $this->assertEquals("Europe/Lisbon", $date->getTimezone()->getName());
        $date->setTimezone(new \DateTimeZone("Africa/Bissau"));
        $this->assertEquals("Africa/Bissau", $date->getTimezone()->getName());
    }

    /**
     * @depends testParse
     * @depends testAdd
     * @depends testFormat
     */
    public function testAddYears()
    {
        $date = static::$d4ope->addYears(50);
        $this->assertEquals("2019-10-05",
                            $date->format(\Rebelo\Date\Date::SQL_DATE));

        $date2 = static::$d4ope->addYears(-9);
        $this->assertEquals("1960-10-05",
                            $date2->format(\Rebelo\Date\Date::SQL_DATE));
    }

    /**
     * @depends testParse
     * @depends testAdd
     * @depends testFormat
     */
    public function testAddMonth()
    {
        $date = static::$d4ope->addMonths(12);
        $this->assertEquals("1970-10-05",
                            $date->format(\Rebelo\Date\Date::SQL_DATE));

        $date2 = static::$d4ope->addMonths(-9);
        $this->assertEquals("1969-01-05",
                            $date2->format(\Rebelo\Date\Date::SQL_DATE));
    }

    /**
     * @depends testParse
     * @depends testAdd
     * @depends testFormat
     */
    public function testAddDays()
    {
        $date = static::$d4ope->addDays(2);
        $this->assertEquals("1969-10-07",
                            $date->format(\Rebelo\Date\Date::SQL_DATE));

        $date2 = static::$d4ope->addDays(-4);
        $this->assertEquals("1969-10-01",
                            $date2->format(\Rebelo\Date\Date::SQL_DATE));
    }

    /**
     * @depends testParse
     * @depends testAdd
     * @depends testFormat
     */
    public function testAddHours()
    {
        $date = static::$d4ope->addHours(10);
        $this->assertEquals("1969-10-05 19:00:00",
                            $date->format(\Rebelo\Date\Date::SQL_DATETIME));

        $date2 = static::$d4ope->addHours(-1);
        $this->assertEquals("1969-10-05 08:00:00",
                            $date2->format(\Rebelo\Date\Date::SQL_DATETIME));
    }

    /**
     * @depends testParse
     * @depends testAdd
     * @depends testFormat
     */
    public function testAddMinuts()
    {
        $date = static::$d4ope->addMinutes(9);
        $this->assertEquals("1969-10-05 09:09:00",
                            $date->format(\Rebelo\Date\Date::SQL_DATETIME));

        $date2 = static::$d4ope->addMinutes(-1);
        $this->assertEquals("1969-10-05 08:59:00",
                            $date2->format(\Rebelo\Date\Date::SQL_DATETIME));
    }

    /**
     * @depends testParse
     * @depends testAdd
     * @depends testFormat
     */
    public function testAddSeconds()
    {
        $date = static::$d4ope->addSeconds(9);
        $this->assertEquals("1969-10-05 09:00:09",
                            $date->format(\Rebelo\Date\Date::SQL_DATETIME));

        $date2 = static::$d4ope->addSeconds(-1);
        $this->assertEquals("1969-10-05 08:59:59",
                            $date2->format(\Rebelo\Date\Date::SQL_DATETIME));
    }

    /**
     * @depends testParse
     */
    public function testToDateTime()
    {
        $this->assertInstanceOf(\DateTime::class, static::$d4ope->toDateTime());
    }

    /**
     *
     */
    public function testClone()
    {
        $now   = new \Rebelo\Date\Date();
        $older = clone $now;
        $older->setYaer(1999);
        $this->assertEquals((new \Rebelo\Date\Date())->format("Y"),
                                                              $now->format("Y"));
        $this->assertEquals("1999", $older->format("Y"));
    }

}
