<?php
require __DIR__ . '/init.php';

Pix_Controller::addCommonHelpers();
Pix_Partial::setTrimMode(true);
Pix_Partial::addCommonHelpers();
Pix_Controller::addDispatcher(new Stuoj\Controller\ControllerDispatcher());
Pix_Controller::dispatch(__DIR__ . '/src/Stuoj');