<?php
#echo php_uname('m'); # x86_64
$start = memory_get_usage();
#$arr = range(1, 1000000);
$arr = array_fill(0, 1000000, 42);
echo (memory_get_usage() - $start) / 1000000, " bytes\n";
/**
 * php 5.6: range - 144.39 bytes, array_fill - 96.39 bytes
 * php 7.0: range -  33.56 bytes, array_fill - 33.56 bytes
 *
 * php 7.0 занимает в 4.3 раза меньше памяти чем php 5.6 на x86_64
 * результаты почти совпали с https://habrahabr.ru/post/247145/
 */
