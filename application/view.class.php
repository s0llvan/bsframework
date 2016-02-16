<?php
/*
 * View class for BSFramework
 *
 * @package BSFramework
 * @version 1.0
 */
class View
{
    public static $variables = array();
 
    static function Set($name, $value)
    {
        View::$variables[$name] = $value;
    }
     
    static function Render($dir, $view)
    {
        extract(View::$variables);

        if(file_exists(ROOT . DS . VIEWS . $dir . DS . $view . '.view.php'))
        {
			include(ROOT . DS . VIEWS . $dir . DS . $view . '.view.php');
		}
        else
        {
			/* throw exception */
            echo "Error - View : $view doesn't exist !";
		}
    }
}