<?php
// Composer autoloading
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    include 'vendor/autoload.php';
}

Pix_Controller::addCommonHelpers();
Pix_Partial::setTrimMode(true);
Pix_Partial::addCommonHelpers();
Pix_Controller::dispatch(__DIR__ . '/src');