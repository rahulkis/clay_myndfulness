<?php

use App\Models\Habbit;

function niceDate($date)
{
    return date('d M, Y ', strtotime($date));
}
function habbitsFromCommaSeparatedIds($string){
    $query = Habbit::query();
    $ids = explode(',',$string);
    return  $query->whereIn('id',$ids)->get();
}
