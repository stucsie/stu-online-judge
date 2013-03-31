<?php
// Composer autoloading
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    include 'vendor/autoload.php';
}

error_reporting(E_ALL ^ E_NOTICE ^ E_STRICT);
$flag = (preg_match('/\.test\./i', $_SERVER["SERVER_NAME"]))
    ? 'On' : 'Off';
ini_set('display_errors', $flag);

define('DB_CONFIGDIR', __DIR__ . "/config/db");
$obj = new StdClass;
$obj = json_decode(file_get_contents(DB_CONFIGDIR . '/stuoj.json'));
Pix_Table::setDefaultDb(new Pix_Table_Db_Adapter_MysqlConf($obj));
Pix_Table::addStaticResultSetHelper('Pix_Array_Volume');

define('PROJECT_NAME', 'STU Online Judge');
