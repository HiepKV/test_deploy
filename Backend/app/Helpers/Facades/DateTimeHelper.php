<?php

namespace App\Helpers\Facades;

use Illuminate\Support\Facades\Facade;

/**
 *
 * @method static int daysDiff($fromDate, $toDate = '')
 * @method static \DateInterval diffOfTwoDate($fromDate, $toDate = '')
 * @method static bool validateDateTime($dateTime, $format = 'Y-m-d H:i:s')
 * @see \App\Helpers\DateTimeHelper;
 */
class DateTimeHelper extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'DateTimeHelper';
    }
}
