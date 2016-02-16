<?php

namespace Ctrl;

use View;

class Main extends \Controller
{    
	public function __construct($controller,$action)
    {
		parent::__construct($controller, $action);
	}
	
	public function index()
    {       
        View::Render('common','head');
        View::Render('common','nav');
        
        View::Render('main','index');
        
        View::Render('common','footer');
	}
}