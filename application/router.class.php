<?php
/*
 * Router class for BSFramework
 *
 * @package BSFramework
 * @version 1.0
 */
class Router
{
    public static function Route($url) {        
        $url_array = array();
	    $url_array = explode("/",$url);
        
        $controller = isset($url_array[0]) ? $url_array[0] : '';
        array_shift($url_array);
        
        $action = isset($url_array[0]) ? $url_array[0] : '';
        
        array_shift($url_array);
	    $query_string = $url_array;

        if(empty($controller))
	       $controller = 'main';
		
	    if(empty($action))
	        $action = 'index';
        
        $controllerName = ucwords($controller);
        $controller = 'Ctrl\\' . $controllerName . '\\' . $action;        
        
        $method = 'index';        
        
        if ((int)method_exists($controller, $method)) {
            $dispatch = new $controller($controllerName, $action);
            
            if(!empty($_POST)) {
                call_user_func_array(array($dispatch,'form'),$query_string)->index();
            } else {
                call_user_func_array(array($dispatch,$method),$query_string);
            }
	    } else {
            $controller = 'Ctrl\\' . $controllerName;
            
            if ((int)method_exists($controller, $method)) {
                $dispatch = new $controller($controllerName, $action);
                
                if(!empty($_POST)) {
                    call_user_func_array(array($dispatch,'form'),$query_string)->index();
                } else {
                    call_user_func_array(array($dispatch,$method),$query_string);
                }
            } else {
                $controller = 'Ctrl\\Main';
            
                $dispatch = new $controller($controllerName, $action);
                call_user_func_array(array($dispatch,$method),$query_string);
            }
	    }
    }
}