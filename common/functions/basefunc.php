<?php

function debug($data){
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

function num_word($value, $words, $show = true)
{
    $num = $value % 100;
    if ($num > 19) {
        $num = $num % 10;
    }

    $out = ($show) ?  $value . ' ' : '';
    switch ($num) {
        case 1:  $out .= $words[0]; break;
        case 2:
        case 3:
        case 4:  $out .= $words[1]; break;
        default: $out .= $words[2]; break;
    }

    return $out;
}

function secToStr($secs)
{
    $res = '';

    $days = floor($secs / 86400);
    $secs = $secs % 86400;
    $res .= num_word($days, array('день', 'дня', 'дней')) . ', ';

    $hours = floor($secs / 3600);
    $secs = $secs % 3600;
    $res .= num_word($hours, array('час', 'часа', 'часов')) . ', ';

    $minutes = floor($secs / 60);
    $secs = $secs % 60;
    $res .= num_word($minutes, array('минута', 'минуты', 'минут')) . ', ';

    $res .= num_word($secs, array('секунда', 'секунды', 'секунд'));

    return $res;
}
