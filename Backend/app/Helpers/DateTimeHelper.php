<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateTimeHelper
{
    public function daysDiff($fromDate, $toDate = ''): int
    {
        return self::diffOfTwoDate($fromDate, $toDate)->d;
    }

    public function diffOfTwoDate($fromDate, $toDate = ''): \DateInterval
    {
        $fromDate = new Carbon($fromDate);
        $toDate = $toDate ? new Carbon($toDate) : Carbon::now();

        return $fromDate->diff($toDate);
    }

    public function validateDateTime($dateTime, $format = 'Y-m-d H:i:s'): bool
    {
        $dateTimeWithFormat = \DateTime::createFromFormat($format, $dateTime);

        return $dateTimeWithFormat && $dateTimeWithFormat->format($format) == $dateTime;
    }
}
