<?php

$path = '/game/log/scribe/';
$categories = ['SIGNUP', 'LOGIN', 'DEPART', 'ASSET', 'ITEM_CHANGE'];

$dbHost = "192.168.56.101";
$dbName = "log";
$dbUser = "root";
$dbPass = "alek384ck32@Q";
$pdo = new PDO("mysql:host=" . $dbHost . ";port=3306;dbname=" . $dbName . ";charset=utf8", $dbUser, $dbPass);

function write($category, $data, $pdo)
{
    $query = query($category, date('Ymd', time()));
    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare($query);

        $stmt->execute($data);

        $pdo->commit();

        $result_row = $stmt->rowCount();

        return $result_row;
    } catch (PDOException $exception) {
        $pdo->rollBack();
    }
}

function query($category, $today)
{
    $query = '';

    switch ($category) {
        case 'signup':
            $query = "insert into " . $category . "_log_" . $today
                . "(log_date, timezone, hive_id, email, nation_id, name, language_id, server_ip, client_ip)"
                . " values (:log_date, :timezone, :hive_id, :email, :nation_id, :name, :language_id, :server_ip, :client_ip)";
            break;
        case 'login':
            $query = "insert into " . $category . "_log_" . $today
                . "(log_date, timezone, hive_id, user_id, server_ip, client_ip)"
                . " values (:log_date, :timezone, :hive_id, :user_id, :server_ip, :client_ip)";
            break;
        case 'depart':
            $query = "insert into " . $category . "_log_" . $today
                . "(log_date, timezone, hive_id, user_id, user_level, map_id, server_ip, client_ip)"
                . " values (:log_date, :timezone, :hive_id, :user_id, :user_level, :map_id, :server_ip, :client_ip)";
            break;
        case 'asset':
            $query = "insert into " . $category . "_log_" . $today
                . "(log_date, timezone, hive_id, user_id, goods_id, asset_id, cost, server_ip, client_ip)"
                . " values (:log_date, :timezone, :hive_id, :user_id, :goods_id, :asset_id, :cost, :server_ip, :client_ip)";
            break;
        case 'item_change':
            $query = "insert into " . $category . "_log_" . $today
                . "(log_date, timezone, hive_id, user_id, before_user_equip_id, current_user_equip_id, server_ip, client_ip)"
                . " values (:log_date, :timezone, :hive_id, :user_id, :before_user_equip_id, :current_user_equip_id, :server_ip, :client_ip)";
            break;
    }
    return $query;
}

function index($path) {
    $data = [];
    try {
        $file = $path."table_index.json";
        echo $file."\n";
        if (!file_exists($file))
            throw new Exception('File not found');
        $fp = fopen($file, 'r');
        if (!$fp)
            throw new Exception('File open failed');

        $data = fgets($fp, 1024);
        fclose($fp);

    } catch(Exception $e) {

    }
    return $data;
}

function index_fix($path, $index)
{
    try {
        $file = $path . "table_index.json";

        if (!file_exists($file))
            throw new Exception('File not found');
        $fp = fopen($file, 'w');
        if (!$fp)
            throw new Exception('File open failed');

        fwrite($fp, json_encode($index));
        fclose($fp);
    } catch (Exception $e) {

    }
}

function read($path, $categories, $pdo)
{
    $today = date('Y-m-d', time());
    $index = index($path);

    foreach ($categories as &$category) {
        try {
            $file = $path . $category . '/' . $category . '-' . $today . '_00000';
            if (!file_exists($file)) {
                throw new Exception('File not found!');
            }

            $fp = fopen($file, 'r');
            if (!$fp) {
                throw new Exception('File open failed');
            }
            $category = strtolower($category);
            $cindex = $index[$category];

            fseek($fp, $cindex, SEEK_SET);
            while (($data = fgets($fp, 1024)) !== false) {
                $data = json_decode($data, true);
                $cindex = ftell($fp);
                write($category, $data, $pdo);
            }
            $index[$category] = $cindex;
            fclose($fp);
        } catch (Exception $e) {

        }
    }
    index_fix($path, $index);
}

read($path, $categories, $pdo);
