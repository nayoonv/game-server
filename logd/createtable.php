<?php

$dbHost = "192.168.56.101";      // 호스트 주소(localhost, 120.0.0.1)
$dbName = "log";      // 데이타 베이스(DataBase) 이름
$dbUser = "root";          // DB 아이디
$dbPass = "alek384ck32@Q";        // DB 패스워드
$pdo = new PDO("mysql:host=" . $dbHost . ";port=3306;dbname=" . $dbName . ";charset=utf8", $dbUser, $dbPass);

function createTable($pdo)
{
    $today = date('Ymd', time() + 24*60*60);
    createLoginLogTable($pdo, $today);
    createSignUpLogTable($pdo, $today);
    createDepartLogTable($pdo, $today);
    createAssetLogTable($pdo, $today);
    createItemChangeLogTable($pdo, $today);
}

function createLoginLogTable($pdo, $today)
{
    $query = "show tables like 'login_log_" . $today . "'; ";
    $result = $pdo->query($query);
    if ($result == false)
        return;

    if ($result->rowCount() <= 0) {
        $query = "create table `login_log_" . $today . "` (
                `log_id` bigint(20) not null auto_increment,
                `log_date` datetime not null,
                `timezone` varchar(20) not null default '',
                `hive_id` int(11) not null,
                `user_id` int(11) not null,
                `server_ip` varchar(32) not null,
                `client_ip` varchar(32) not null,
                primary key (`log_id`)
            )";

        $pdo->query($query);
    }
}

function createSignUpLogTable($pdo, $today)
{
    $query = "show tables like 'signup_log_" . $today . "'; ";
    $result = $pdo->query($query);
    if ($result == false)
        return;

    if ($result->rowCount() <= 0) {
        $query = "create table `signup_log_" . $today . "`(
                `log_id` bigint(20) not null auto_increment,
                `log_date` datetime not null,
                `timezone` varchar(20) not null default '',
                `hive_id` int(11) not null,
                `email` varchar(20) not null,
                `nation_id` int(11) not null,
                `language_id` int(11) not null,
                `server_ip` varchar(32) not null,
                `client_ip` varchar(32) not null,
                primary key (`log_id`)
            )";

        $pdo->query($query);
    }
}

createTable($pdo);

function createDepartLogTable($pdo, $today)
{
    $query = "show tables like 'depart_log_" . $today . "'; ";
    $result = $pdo->query($query);
    if ($result == false)
        return;

    if ($result->rowCount() <= 0) {
        $query = "create table `depart_log_" . $today . "` (
                `log_id` bigint(20) not null auto_increment,
                `log_date` datetime not null,
                `timezone` varchar(20) not null default '',
                `hive_id` int(11) not null,
                `user_id` int(11) not null,
                `user_level` int(11) not null,
                `map_id` int(11) not null,
                `server_ip` varchar(32) not null,
                `client_ip` varchar(32) not null,
                primary key (`log_id`)
            )";

        $pdo->query($query);
    }
}

function createAssetLogTable($pdo, $today)
{
    $query = "show tables like 'asset_log_" . $today . "'; ";
    $result = $pdo->query($query);
    if ($result == false)
        return;

    if ($result->rowCount() <= 0) {
        $query = "create table `asset_log_" . $today . "` (
                `log_id` bigint(20) not null auto_increment,
                `log_date` datetime not null,
                `timezone` varchar(20) not null default '',
                `hive_id` int(11) not null,
                `user_id` int(11) not null,
                `goods_id` int(11) not null,
                `asset_id` int(11) not null,
                `server_ip` varchar(32) not null,
                `client_ip` varchar(32) not null,
                primary key (`log_id`)
            )";

        $pdo->query($query);
    }
}

function createItemChangeLogTable($pdo, $today)
{
    $query = "show tables like 'item_change_log_" . $today . "'; ";
    $result = $pdo->query($query);
    if ($result == false)
        return;

    if ($result->rowCount() <= 0) {
        $query = "create table `item_change_log_" . $today . "` (
                `log_id` bigint(20) not null auto_increment,
                `log_date` datetime not null,
                `timezone` varchar(20) not null default '',
                `hive_id` int(11) not null,
                `user_id` int(11) not null,
                `before_user_equip_id` int(11) not null,
                `current_user_equip_id` int(11) not null,
                `server_ip` varchar(32) not null,
                `client_ip` varchar(32) not null,
                primary key (`log_id`)
            )";

        $pdo->query($query);
    }
}
