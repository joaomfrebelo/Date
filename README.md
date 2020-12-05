# Rebelo\Date

This class relays on the DateTime class of php but change the return type
for some methods and have more methods.
Methods like add and sub return a new Object instead of change the instance it self.
This class have methods like addDays, addMonths, addYears, addHours, etc

## Example
Initiate an instance of \Rebelo\Date\Date
```php
    $date = \Rebelo\Date\Date::parse(
        \Rebelo\Date\Date::SQL_DATETIME, "1969-10-05 09:00:00"
    );

    OR                                              

    $date = \Rebelo\Date\Date::createFromFormat(
        \Rebelo\Date\Date::SQL_DATETIME, 
        "1969-10-05 09:00:00",  
        new \DateTimeZone("Europe/Lisbon")
    );

    OR for Date now                                                    
    
    $date = new \Rebelo\Date\Date();
    
    OR get Date from NTP server  

    $date = \Rebelo\Date\Date::ntp();
```

Get a formated string
```php
$string = $date->format(Date::SQL_DATE)
```

Add and Subtract Years
```php
$date2 = $date->addYears(50);
$date3 = $date->addYears(-9)
```
Set the Month
```php
$date->setMonth(9)
```

## Install

Via Composer

```bash
$ composer require joaomfrebelo/Date
```


## License
MIT License
Copyright (c) 2019 João M F Rebelo

 Permission is hereby granted, free of charge, to any person obtaining a copy
 of this software and associated documentation files (the "Software"), to deal
 in the Software without restriction, including without limitation the rights
 to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 copies of the Software, and to permit persons to whom the Software is
 furnished to do so, subject to the following conditions:

 The above copyright notice and this permission notice shall be included in
 all copies or substantial portions of the Software.

 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 THE SOFTWARE.