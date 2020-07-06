<?php
namespace Utils;

class CalendarTools
{

    const MODE_MONTH = "MONTH";
    const MODE_WEEK = "WEEK";
    const MODE_DAY = "DAY";

    public static function getCalendarMode($start, $end)
    {
        $diff = (intval($end) - intval($start)) / (60 * 60 * 24);
        if ($diff > 8) {
            return CalendarTools::MODE_MONTH;
        } elseif ($diff > 2) {
            return CalendarTools::MODE_WEEK;
        } else {
            return CalendarTools::MODE_DAY;
        }
    }

    public static function addLeadingZero($val)
    {
        if ($val < 10) {
            $val = "0" . $val;
        }
        return $val;
    }

    public static function getTimeDiffInHours($start, $end)
    {
        $diff = strtotime($end) - strtotime($start);
        $hours = round($diff/(3600), 2);
        return $hours;
    }

    public static function getDaysBetweenDates($start, $end)
    {
        $begin = new \DateTime($start);
        $end = new \DateTime($end);
        $end = $end->add(\DateInterval::createFromDateString('1 day'));
        $interval = \DateInterval::createFromDateString('1 day');
        $period = new \DatePeriod($begin, $interval, $end);
        $days = array();
        foreach ($period as $dt) {
            $days[] = $dt;
        }
        return $days;
    }

    public static function addMinutesToDateTime($datetime, $minutes, $format = 'Y-m-d H:i:s')
    {
        $time = new \DateTime($datetime);
        $time = $time->add(new \DateInterval('PT' . $minutes . 'M'));

        return $time->format($format);
    }

    public static function addMonthsToDateTime($datetime, $months, $format = 'Y-m-d H:i:s')
    {
        $time = new \DateTime($datetime);
        $time = $time->add(new \DateInterval('P' . $months . 'M'));

        return $time->format($format);
    }

    public static function getNumberOfDaysBetweenDates($later, $earlier)
    {
        $timeFirst = new \DateTime($later);
        $timeSecond = new \DateTime($earlier);
        $interval = $timeSecond->diff($timeFirst);
        return intval($interval->format('%a')) + 1;
    }

    public static function getNumberOfMonthsBetweenDates($date1, $date2)
    {
        $begin = new \DateTime($date1);
        $end = new \DateTime($date2);
        $end = $end->modify('+1 day');

        $interval = \DateInterval::createFromDateString('1 month');

        $period = new \DatePeriod($begin, $interval, $end);
        $counter = 0;
        foreach ($period as $dt) {
            $counter++;
        }

        return $counter;
    }
}
