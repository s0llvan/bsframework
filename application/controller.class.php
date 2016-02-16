<?php
/*
 * Controller class for BSFramework
 *
 * @package BSFramework
 * @version 1.0
 */
abstract class Controller
{
    private $controller;
   	private $action;
	private $models;
	private $view;
    
    protected $lang;
	
	public function __construct($controller, $action) {		
		$this->controller = $controller;
       	$this->action = $action;
		$this->view = new View();
        
        $this->lang = new Language(WEBSITE_LANGUAGE);

        View::Set('lang', $this->lang);
	}
    
    // Load model class
	public function LoadModel($model) {
		if(class_exists($model)) {
			$this->models[$model] = new $model();
		}		
	}
	
	// Get the instance of the loaded model class
	public function GetModel($model) {        
		if(is_object($this->models[$model])) {
			return $this->models[$model];
		} else {
			return false;
		}
	}
    
    // Get the value of post method
    public function GetParam($param) {
        return htmlspecialchars((isset($_POST[$param]) ? $_POST[$param] : null));
    }
    
    // Get all values of post method
    public function GetParams() {
        $data = array();
        foreach($_POST as $key => $value) {
            $data[$key] = is_array($value) ? $value : htmlspecialchars($value);
        }
        return $data;
    }
    
    // Redirect function
    public function Redirect($url) {
        header('Location: ' . $url);
    }

    // Redirect function
    public function RedirectToIndex() {
        header('Location: ' . WEBSITE_ADDRESS);
        exit();
    }

    public function LoadLib($lib) {
        require_once(ROOT . "libraries/$lib");
    }
}