<?php

namespace Stuoj\Controller;

class ControllerDispatcher extends \Pix_Controller_Dispatcher 
{
    public function dispatch($url)
    {
        list(, $controllerName, $actionName) = explode(DIRECTORY_SEPARATOR, $url);
        list($actionName, $ext) = explode('.', $actionName);
        $args = array();
        if ($ext) {
            $args['ext'] = $ext;
        }

        $actionName = $actionName ? $actionName : 'index';
        $controllerName = $controllerName ? $controllerName : 'index';

        if (!preg_match('/^([A-Za-z]{1,})$/' , $controllerName)) {
            return null;
        }
        if (!preg_match('/^([A-Za-z][A-Za-z0-9]*)$/' , $actionName)) {
            return array($controllerName, null);
        }
        $controllerName = 'Stuoj\\Controller\\' . $controllerName;
        return array($controllerName, $actionName, $args);
    }    
}
