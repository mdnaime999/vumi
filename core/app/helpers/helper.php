<?php

function en_to_bn($value)
{
    $bn = ["১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০"];
    $en = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "0"];

    $result = str_replace($en, $bn, $value);
    return $result;
}
function bn_to_en($value)
{
    $bn = ["১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০"];
    $en = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "0"];

    $result = str_replace($bn, $en, $value);
    return $result;
}
