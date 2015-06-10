<?php
defined('IN_UF') or exit('Access Denied');

// 当前时间
$cur_year = date("Y");
$cur_mon = date("m");
$cur_day = date("d");
$cur_hour = date('H');
$cur_minite = date('i');
$cur_second = date('s');
$str_cur_time = "$cur_year,$cur_mon,$cur_day,$cur_hour,$cur_minite,$cur_second";

// 问候语
$int_hour = date("H",time());

if($int_hour >= 18 && $int_hour <= 23){
    $str_hello = "晚上好！";
}
elseif($int_hour >= 0 && $int_hour <= 5){
    $str_hello = "夜里好！";
}
elseif($int_hour >= 6 && $int_hour <= 8){
    $str_hello = "早上好！";
}
elseif($int_hour >= 9 && $int_hour <= 11){
    $str_hello = "上午好！";
}
elseif($int_hour >= 12 && $int_hour <= 13){
    $str_hello = "中午好！";
}
elseif($int_hour >= 14 && $int_hour <= 17){
    $str_hello = "下午好！";
}

include(Template("top"));
?>