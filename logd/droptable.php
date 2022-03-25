<?php

$dbHost = "192.168.56.101";      // 호스트 주소(localhost, 120.0.0.1)
$dbName = "log";      // 데이타 베이스(DataBase) 이름
$dbUser = "root";          // DB 아이디
$dbPass = "alek384ck32@Q";        // DB 패스워드
$pdo = new PDO("mysql:host=" . $dbHost . ";port=3306;dbname=" . $dbName . ";charset=utf8", $dbUser, $dbPass);

function dropTable($pdo)
{
    $date = date('Ymd', time() - 30*24*60*60*3);
    dropLoginLogTable($pdo, $date);
    dropSignUpLogTable($pdo, $date);
    dropDepartLogTable($pdo, $date);
    dropAssetLogTable($pdo, $date);
    dropItemChangeLogTable($pdo, $date);
}

function dropLoginLogTable($pdo, $date) {
    $query = "drop table if exists login_log_".$date;
    $pdo->query($query);
}

function dropSignUpLogTable($pdo, $date) {
    $query = "drop table if exists signup_log_".$date;
    $pdo->query($query);
}

function dropDepartLogTable($pdo, $date) {
    $query = "drop table if exists depart_log_".$date;
    $pdo->query($query);
}

function dropAssetLogTable($pdo, $date) {
    $query = "drop table if exists asset_log_".$date;
    $pdo->query($query);
}

function dropItemChangeLogTable($pdo, $date) {
    $query = "drop table if exists item_change_log_".$date;
    $pdo->query($query);
}