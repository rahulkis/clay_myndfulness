<?php

namespace App\Helper;

use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Response;

class CommonHelper
{
    public static function badRequestResponse($message = null)
    {
        return response()->json([
            "message" => $message ?? __("messages.request_faild"),
        ], Response::HTTP_BAD_REQUEST);
    }
    public static function convertToHumanReadable(Int $seconds)
    {
        $dt1 = new DateTime("@0");
        $dt2 = new DateTime("@$seconds");
        return $dt1->diff($dt2)->format('%a days, %h hours, %i minutes and %s seconds');
    }
    public static function currentWeekDates()
    {
        $date = Carbon::now(); // or $date = new Carbon();
        return [
            $date->startOfWeek(), // 2016-10-17 00:00:00.000000
            $date->copy()->endOfWeek(), // 2016-10-23 23:59:59.000000
        ];
    }
    public static function currentMonthDates()
    {
        $date = Carbon::now(); // or $date = new Carbon();
        return [
            $date->startOfMonth(), // 2016-10-17 00:00:00.000000
            $date->copy()->endOfMonth(), // 2016-10-23 23:59:59.000000
        ];
    }
    public static function currentYearDates()
    {
        $date = Carbon::now(); // or $date = new Carbon();
        return [
            $date->startOfYear(), // 2016-10-17 00:00:00.000000
            $date->copy()->endOfYear(), // 2016-10-23 23:59:59.000000
        ];
    }
}
