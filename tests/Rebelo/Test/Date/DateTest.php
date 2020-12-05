<?php
/**
 * MIT License
 *
 * Copyright (c) 2019 João M F Rebelo
 */
declare(strict_types=1);

namespace Rebelo\Test\Date;

require_once __DIR__.'/CommnunTest.php';

use Rebelo\Date\Date;

/**
 * tests of \Rebelo\Date\Date class
 *
 * @author João Rebelo
 */
class DateTest extends \PHPUnit\Framework\TestCase
{

    public function testReflection(): void
    {
        (new \Rebelo\Test\CommnunTest())->testReflection(\Rebelo\Date\Date::class);
        //(new \Rebelo\Test\CommnunTest())->testReflection(\Rebelo\Date\Socket::class);
        //(new \Rebelo\Test\CommnunTest())->testReflection(\Rebelo\Date\Client::class);
    }
    
    /**
     *
     * @var \Rebelo\Date\Date
     */
    static $d4ope;

    public function testInstance(): void
    {
        $date = new \Rebelo\Date\Date();
        $this->assertInstanceOf(\Rebelo\Date\Date::class, $date);
    }

    /**
     * @depends testInstance
     */
    public function testParse(): void
    {
        $date = \Rebelo\Date\Date::createFromFormat(
            Date::SQL_DATETIME, "1969-10-05 09:00:00",
            new \DateTimeZone("Europe/Lisbon")
        );
        $this->assertInstanceOf(\Rebelo\Date\Date::class, $date);

        static::$d4ope = $date;
    }

    public function testParseDayNotExist(): void
    {
        $this->expectException(\Rebelo\Date\DateParseException::class);
        \Rebelo\Date\Date::createFromFormat(Date::SQL_DATE, "1969-04-31");
    }

    public function testParseWrongFormat(): void
    {
        $this->expectException(\Rebelo\Date\DateParseException::class);
        \Rebelo\Date\Date::createFromFormat(Date::SQL_DATE, "1969-31");
    }

    /**
     * @depends testParse
     */
    public function testCreateFromFormat(): void
    {
        $date = \Rebelo\Date\Date::createFromFormat(Date::SQL_DATE, "1969-10-05");
        $this->assertInstanceOf(\Rebelo\Date\Date::class, $date);
    }

    /**
     * @depends testParse
     */
    public function testFormat(): void
    {
        $date = \Rebelo\Date\Date::createFromFormat(Date::SQL_DATE, "1969-10-05");
        $this->assertEquals("1969-10-05", $date->format(Date::SQL_DATE));
    }

    /**
     * @depends testParse
     * @depends testFormat
     */
    public function testAdd(): void
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
    public function testSub(): void
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
    public function testDiff(): void
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
    public function testOffset(): void
    {
        $date = \Rebelo\Date\Date::parse(
            Date::SQL_DATE, "1969-10-05", new \DateTimeZone("Europe/Lisbon")
        );
        $this->assertEquals(3600, $date->getOffset());
    }

    /**
     * @depends testParse
     */
    public function testTimestamp(): void
    {
        $date = \Rebelo\Date\Date::parse(
            Date::SQL_DATETIME, "2019-10-05 09:00:00",
            new \DateTimeZone("Europe/Lisbon")
        );
        $this->assertEquals(1570262400, $date->getTimestamp());
    }

    /**
     * @depends testParse
     */
    public function testTimeszone(): void
    {
        $date = \Rebelo\Date\Date::parse(
            Date::SQL_DATETIME, "2019-10-05 09:00:00",
            new \DateTimeZone("Europe/Lisbon")
        );
        $this->assertEquals("Europe/Lisbon", $date->getTimezone()->getName());
    }

    /**
     * @depends testParse
     */
    public function testModify(): void
    {
        $date = \Rebelo\Date\Date::parse(
            Date::SQL_DATETIME, "1969-10-05 09:00:00",
            new \DateTimeZone("Europe/Lisbon")
        );
        $this->assertEquals(
            "1969-10-05 09:00:00", $date->format(Date::SQL_DATETIME)
        );
        $date->modify("+50 year");
        $this->assertEquals(
            "2019-10-05 09:00:00", $date->format(Date::SQL_DATETIME)
        );
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
    public function testSetDate(): void
    {
        $date = new \Rebelo\Date\Date();
        //Set the date and return the self instance
        $this->assertInstanceOf(
            \Rebelo\Date\Date::class, $date->setDate(1969, 10, 5)
        );
        $this->assertEquals(
            "1969-10-05", $date->format(\Rebelo\Date\Date::SQL_DATE)
        );
    }

    /**
     * @depends testInstance
     * @depends testFormat
     * @depends testSetDate
     */
    public function testSetYear(): void
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
    public function testSetMonth(): void
    {
        $date = \Rebelo\Date\Date::parse(
            \Rebelo\Date\Date::SQL_DATE, "1969-10-05"
        );
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
    public function testSetDay(): void
    {
        $date = \Rebelo\Date\Date::parse(
            \Rebelo\Date\Date::SQL_DATE, "1969-10-05"
        );
        //Set the month and return the self instance
        $this->assertInstanceOf(\Rebelo\Date\Date::class, $date->setDay(9));
        $this->assertEquals(9, $date->format(\Rebelo\Date\Date::DAY_LESS));
    }

    /**
     * @depends testInstance
     * @depends testFormat
     */
    public function testExceptiontMonthSetDate(): void
    {
        $date = new \Rebelo\Date\Date();
        $this->expectException(\Rebelo\Date\DateParseException::class);
        $date->setDate(1999, 99, 5);
    }

    /**
     * @depends testInstance
     * @depends testFormat
     */
    public function testExceptiontDaySetDate(): void
    {
        $date = new \Rebelo\Date\Date();
        $this->expectException(\Rebelo\Date\DateParseException::class);
        $date->setDate(1999, 10, 50);
    }

    /**
     * @depends testInstance
     * @depends testFormat
     */
    public function testSetIsoDate(): void
    {
        $date = new \Rebelo\Date\Date();
        $date->setISODate(2008, 2, 7);
        $this->assertEquals(
            "2008-01-13", $date->format(\Rebelo\Date\Date::SQL_DATE)
        );
    }

    /**
     * @depends testInstance
     * @depends testFormat
     */
    public function testSetTime(): void
    {
        $date = new \Rebelo\Date\Date();
        //Set the time and return the self instance
        $this->assertInstanceOf(
            \Rebelo\Date\Date::class, $date->setTime(9, 29, 59, 102999)
        );
        $this->assertEquals("09:29:59", $date->format(\Rebelo\Date\Date::TIME));
        $this->assertEquals(
            "09:29:59.102", $date->format(\Rebelo\Date\Date::TIME_MICRO_SECONDS)
        );
        $this->assertEquals(
            "09:29:59.102999",
            $date->format(\Rebelo\Date\Date::TIME_MICRO_L_SECONDS)
        );
    }

    /**
     * @depends testInstance
     * @depends testFormat
     */
    public function testSetTimeExcptionHourGrater(): void
    {
        $date = new \Rebelo\Date\Date();
        $this->expectException(\Rebelo\Date\DateException::class);
        $date->setTime(25, 0);
    }

    /**
     * @depends testInstance
     * @depends testFormat
     */
    public function testSetTimeExcptionHourLower(): void
    {
        $date = new \Rebelo\Date\Date();
        $this->expectException(\Rebelo\Date\DateException::class);
        $date->setTime(-1, 0);
    }

    /**
     * @depends testInstance
     * @depends testFormat
     */
    public function testSetTimeExcptionMinuteGrater(): void
    {
        $date = new \Rebelo\Date\Date();
        $this->expectException(\Rebelo\Date\DateException::class);
        $date->setTime(0, 60);
    }

    /**
     * @depends testInstance
     * @depends testFormat
     */
    public function testSetTimeExcptionMinuteLower(): void
    {
        $date = new \Rebelo\Date\Date();
        $this->expectException(\Rebelo\Date\DateException::class);
        $date->setTime(0, -1);
    }

    /**
     * @depends testInstance
     * @depends testFormat
     */
    public function testSetTimeExcptionSecondGrater(): void
    {
        $date = new \Rebelo\Date\Date();
        $this->expectException(\Rebelo\Date\DateException::class);
        $date->setTime(0, 0, 60);
    }

    /**
     * @depends testInstance
     * @depends testFormat
     */
    public function testSetTimeExcptionSecondLower(): void
    {
        $date = new \Rebelo\Date\Date();
        $this->expectException(\Rebelo\Date\DateException::class);
        $date->setTime(0, 0, -1);
    }

    /**
     * @depends testInstance
     * @depends testFormat
     */
    public function testSetTimeExcptionMicroGrater(): void
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
    public function testSetHour(): void
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
    public function testSetMinutes(): void
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
    public function testSetSeconds(): void
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
    public function testSetMicroseconds(): void
    {
        $date = new \Rebelo\Date\Date();
        //Set microseconds and return the self instance
        $this->assertInstanceOf(
            \Rebelo\Date\Date::class, $date->setTime(9, 29, 59, 102999)
        );
        $date->setMicroseconds(999425);
        $this->assertEquals(
            999425, $date->format(\Rebelo\Date\Date::MICRO_SECONDS)
        );
    }

    /**
     * @depends testInstance
     * @depends testFormat
     */
    public function testSetTimeExcptionMicroLower(): void
    {
        $date = new \Rebelo\Date\Date();
        $this->expectException(\Rebelo\Date\DateException::class);
        $date->setTime(0, 0, 0, 1000000);
    }

    /**
     * @depends testParse
     * @depends testFormat
     */
    public function testSetTimeStamp(): void
    {
        $date = \Rebelo\Date\Date::parse(
            Date::SQL_DATETIME, "2000-10-05 09:09:59",
            new \DateTimeZone("Europe/Lisbon")
        );
        $date->setTimestamp(1570262400);
        $this->assertEquals(
            "2019-10-05 09:00:00", $date->format(Date::SQL_DATETIME)
        );
    }

    /**
     * @depends testInstance
     */
    public function testSetTimeZone(): void
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
    public function testAddYears(): void
    {
        $date = static::$d4ope->addYears(50);
        $this->assertEquals(
            "2019-10-05", $date->format(\Rebelo\Date\Date::SQL_DATE)
        );

        $date2 = static::$d4ope->addYears(-9);
        $this->assertEquals(
            "1960-10-05", $date2->format(\Rebelo\Date\Date::SQL_DATE)
        );
    }

    /**
     * @depends testParse
     * @depends testAdd
     * @depends testFormat
     */
    public function testAddMonth(): void
    {
        $date = static::$d4ope->addMonths(12);
        $this->assertEquals(
            "1970-10-05", $date->format(\Rebelo\Date\Date::SQL_DATE)
        );

        $date2 = static::$d4ope->addMonths(-9);
        $this->assertEquals(
            "1969-01-05", $date2->format(\Rebelo\Date\Date::SQL_DATE)
        );
    }

    /**
     * @depends testParse
     * @depends testAdd
     * @depends testFormat
     */
    public function testAddDays(): void
    {
        $date = static::$d4ope->addDays(2);
        $this->assertEquals(
            "1969-10-07", $date->format(\Rebelo\Date\Date::SQL_DATE)
        );

        $date2 = static::$d4ope->addDays(-4);
        $this->assertEquals(
            "1969-10-01", $date2->format(\Rebelo\Date\Date::SQL_DATE)
        );
    }

    /**
     * @depends testParse
     * @depends testAdd
     * @depends testFormat
     */
    public function testAddHours(): void
    {
        $date = static::$d4ope->addHours(10);
        $this->assertEquals(
            "1969-10-05 19:00:00",
            $date->format(\Rebelo\Date\Date::SQL_DATETIME)
        );

        $date2 = static::$d4ope->addHours(-1);
        $this->assertEquals(
            "1969-10-05 08:00:00",
            $date2->format(\Rebelo\Date\Date::SQL_DATETIME)
        );
    }

    /**
     * @depends testParse
     * @depends testAdd
     * @depends testFormat
     */
    public function testAddMinuts(): void
    {
        $date = static::$d4ope->addMinutes(9);
        $this->assertEquals(
            "1969-10-05 09:09:00",
            $date->format(\Rebelo\Date\Date::SQL_DATETIME)
        );

        $date2 = static::$d4ope->addMinutes(-1);
        $this->assertEquals(
            "1969-10-05 08:59:00",
            $date2->format(\Rebelo\Date\Date::SQL_DATETIME)
        );
    }

    /**
     * @depends testParse
     * @depends testAdd
     * @depends testFormat
     */
    public function testAddSeconds(): void
    {
        $date = static::$d4ope->addSeconds(9);
        $this->assertEquals(
            "1969-10-05 09:00:09",
            $date->format(\Rebelo\Date\Date::SQL_DATETIME)
        );

        $date2 = static::$d4ope->addSeconds(-1);
        $this->assertEquals(
            "1969-10-05 08:59:59",
            $date2->format(\Rebelo\Date\Date::SQL_DATETIME)
        );
    }

    /**
     * @depends testParse
     */
    public function testToDateTime(): void
    {
        $this->assertInstanceOf(\DateTime::class, static::$d4ope->toDateTime());
    }

    /**
     *
     */
    public function testClone(): void
    {
        $now   = new \Rebelo\Date\Date();
        $older = clone $now;
        $older->setYaer(1999);
        $this->assertEquals(
            (new \Rebelo\Date\Date())->format("Y"), $now->format("Y")
        );
        $this->assertEquals("1999", $older->format("Y"));
    }

    /**
     *
     */
    public function testParseDateNoTime(): void
    {
        $string = "2020-10-05";
        $date   = \Rebelo\Date\Date::parse(
            \Rebelo\Date\Date::SQL_DATE, $string
        );

        $this->assertSame($string, $date->format(\Rebelo\Date\Date::SQL_DATE));
        $this->assertSame(
            $string." 00:00:00.000000",
            $date->format(\Rebelo\Date\Date::SQL_DATETIME.".".\Rebelo\Date\Date::MICRO_SECONDS)
        );
    }

    /**
     *
     * @return array<array<\Rebelo\Date\Date>>
     */
    public function dateProvider(): array
    {
        $stack   = [];
        $day     = \Rebelo\Date\Date::parse(
            \Rebelo\Date\Date::SQL_DATE, "2020-10-05"
        );
        $dayTime = \Rebelo\Date\Date::parse(
            \Rebelo\Date\Date::SQL_DATETIME, "2020-10-05 09:49:09"
        );
        // Test only date
        $stack[] = [
            $day,
            $day->addDays(-1),
            $day->addDays(1),
            clone $day
        ];

        //test date and time, change date
        $stack[] = [
            $dayTime,
            $dayTime->addDays(-1),
            $dayTime->addDays(1),
            clone $dayTime
        ];
        //test date and time, change time
        $stack[] = [
            $dayTime,
            $dayTime->addSeconds(-1),
            $dayTime->addSeconds(1),
            clone $dayTime
        ];
        //test date and time, change microseconds
        $stack[] = [
            (clone $dayTime)->setMicroseconds(500),
            (clone $dayTime)->setMicroseconds(0),
            (clone $dayTime)->setMicroseconds(999),
            (clone $dayTime)->setMicroseconds(500)
        ];

        return $stack;
    }

    /**
     * @dataProvider dateProvider
     */
    public function testIsEarlier(\Rebelo\Date\Date $day,
                                  \Rebelo\Date\Date $earlier,
                                  \Rebelo\Date\Date $later,
                                  \Rebelo\Date\Date $equal): void
    {
        $this->assertFalse($day->isEarlier($earlier));
        $this->assertTrue($day->isEarlier($later));
        $this->assertFalse($day->isEarlier($equal));
    }

    /**
     * @dataProvider dateProvider
     */
    public function testIsLater(\Rebelo\Date\Date $day,
                                \Rebelo\Date\Date $earlier,
                                \Rebelo\Date\Date $later,
                                \Rebelo\Date\Date $equal): void
    {
        $this->assertTrue($day->isLater($earlier));
        $this->assertFalse($day->isLater($later));
        $this->assertFalse($day->isLater($equal));
    }

    /**
     * @dataProvider dateProvider
     */
    public function testIsEqual(\Rebelo\Date\Date $day,
                                \Rebelo\Date\Date $earlier,
                                \Rebelo\Date\Date $later,
                                \Rebelo\Date\Date $equal): void
    {
        $this->assertFalse($day->isEqual($earlier));
        $this->assertFalse($day->isEqual($later));
        $this->assertTrue($day->isEqual($equal));
    }

    /**
     * @dataProvider dateProvider
     */
    public function testIsEarlierOrEqual(\Rebelo\Date\Date $day,
                                         \Rebelo\Date\Date $earlier,
                                         \Rebelo\Date\Date $later,
                                         \Rebelo\Date\Date $equal): void
    {
        $this->assertFalse($day->isEarlierOrEqual($earlier));
        $this->assertTrue($day->isEarlierOrEqual($later));
        $this->assertTrue($day->isEarlierOrEqual($equal));
    }

    /**
     * @dataProvider dateProvider
     */
    public function testIsLaterOrEqual(\Rebelo\Date\Date $day,
                                       \Rebelo\Date\Date $earlier,
                                       \Rebelo\Date\Date $later,
                                       \Rebelo\Date\Date $equal): void
    {
        $this->assertTrue($day->isLaterOrEqual($earlier));
        $this->assertFalse($day->isLaterOrEqual($later));
        $this->assertTrue($day->isLaterOrEqual($equal));
    }

    /**
     * 
     * @return void
     */
    public function testNtp(): void
    {
        $message = "Please verify if is error or is your computer clock that as "
            ."a wrong time up to seconds, the difference is %s seconds to server %s ";

        $delta = 10;

        $dateNoArg = \Rebelo\Date\Date::ntp();
        $this->assertInstanceOf(\Rebelo\Date\Date::class, $dateNoArg);
        $diffArg   = \abs(
            ((int) (new \Rebelo\Date\Date())->format(\Rebelo\Date\Date::UNIX_TIMESTAMP))
            -
            ((int) $dateNoArg->format(\Rebelo\Date\Date::UNIX_TIMESTAMP))
        );

        $this->assertTrue($diffArg < $delta, \sprintf($message, $diffArg, "not set"));

        $dateServer = \Rebelo\Date\Date::ntp("0.pool.ntp.org");
        $this->assertInstanceOf(\Rebelo\Date\Date::class, $dateServer);


        foreach (\Rebelo\Date\Date::$ntpPoll as $server) {
            $dateServer = \Rebelo\Date\Date::ntp($server);
            $this->assertInstanceOf(\Rebelo\Date\Date::class, $dateServer);

            $diffServer = \abs(
                ((int) (new \Rebelo\Date\Date())->format(\Rebelo\Date\Date::UNIX_TIMESTAMP))
                -
                ((int) $dateServer->format(\Rebelo\Date\Date::UNIX_TIMESTAMP))
            );

            $this->assertTrue(
                $diffServer < $delta,
                \sprintf($message, $diffServer, $server)
            );
        }
    }

    /**
     * 
     */
    public function testDateTimeZone(): void
    {
        $lisbon     = new \DateTimeZone("Europe/Lisbon");
        $madrid     = new \DateTimeZone("Europe/Madrid");
        $date       = new \Rebelo\Date\Date(null, $lisbon);
        $this->assertSame(
            $lisbon->getName(), $date->getTimezone()->getName()
        );
        $lisbonHour = (int) $date->format(\Rebelo\Date\Date::HOUR_24_SHORT);
        $date->setTimezone($madrid);
        $madridHour = (int) $date->format(\Rebelo\Date\Date::HOUR_24_SHORT);
        $this->assertSame($lisbonHour + 1, $madridHour);
    }

    /**
     * 
     * @return void
     */
    public function testNtpDateTimeZone(): void
    {
        $lisbon     = new \DateTimeZone("Europe/Lisbon");
        $madrid     = new \DateTimeZone("Europe/Madrid");
        $ntpLisbon  = \Rebelo\Date\Date::ntp(null, $lisbon);
        $ntpMadrid  = \Rebelo\Date\Date::ntp(null, $madrid);
        $lisbonHour = (int) $ntpLisbon->format(\Rebelo\Date\Date::HOUR_24_SHORT);
        $madridHour = (int) $ntpMadrid->format(\Rebelo\Date\Date::HOUR_24_SHORT);
        $this->assertSame($lisbonHour + 1, $madridHour);
    }
}