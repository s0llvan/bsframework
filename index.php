<?php
/**
 * BSFramework
 *
 * @package BSFramework
 * @version 1.0
 */
session_start();

require('config.php');
require(CORE . 'functions.php');
require(CORE . 'mysql.class.php');

// Set development or production environment
switch (ENVIRONMENT) {
    case 'development':
        error_reporting(E_ALL);
        break;
    
    case 'production':
        error_reporting(0);
        break;
    
    default:
        exit('The application environment is not set correctly.');
}

// Load default application files
__autoload('controller.class');
__autoload('view.class');
__autoload('router.class');
__autoload('model.class');
__autoload('language.class');

// Load all *.php files in application/helpers
__autoload_php(ROOT . HELPERS);

// Load all *.php files in application/models
__autoload_php(ROOT . MODELS);

// Load all *.php files in application/controllers
__autoload_php(ROOT . CONTROLLERS);

$url = (isset($_GET['url'])) ? $_GET['url'] : '';
Router::Route($url);