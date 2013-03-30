<?php
// Composer autoloading
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    include 'vendor/autoload.php';
}

error_reporting(E_ALL ^ E_NOTICE ^ E_STRICT);
$flag = (preg_match('/\.test\./i', $_SERVER["SERVER_NAME"]))
    ? 'On' : 'Off';
ini_set('display_errors', $flag);

Pix_Controller::addCommonHelpers();
Pix_Partial::setTrimMode(true);
Pix_Partial::addCommonHelpers();
Pix_Controller::dispatch(__DIR__ . '/src');