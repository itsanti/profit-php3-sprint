<?php
require 'DB.php';

use DByte\DB;

$pdo = new PDO(
    'mysql:dbname=fw;host=127.0.0.1',
    'root',
    '',
    array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ));

DB::$c = $pdo;
