<?php

namespace App\Helper;

class Common
{

    /** Return success response
     * @param $date
     * @return string
     */

    public static function dateColor($date): string
    {
        if (is_null($date)) {
            return '--';
        }

        $formattedDate = $date->translatedFormat(company()->date_format);
        $todayText = __('app.today');

        if ($date->endOfDay()->isPast()) {
            return '<span class="text-danger">' . $formattedDate . '</span>';
        }

        if ($date->setTimezone(company()->timezone)->isToday()) {
            return '<span class="text-success">' . $todayText . '</span>';
        }

        return '<span>' . $formattedDate . '</span>';
    }

    public static function active(): string
    {
        return '<i class="fa fa-circle mr-1 text-light-green f-10"></i>' . __('app.active');
    }

    public static function inactive(): string
    {
        return '<i class="fa fa-circle mr-1 text-red f-10"></i>' . __('app.inactive');
    }

}
