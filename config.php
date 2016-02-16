<?php
/*
 * Configuration file for BSFramework
 *
 * @package BSFramework
 * @version 1.0
 */
define('WEBSITE_NAME', '');
define('WEBSITE_DESCRIPTION', '');
define('WEBSITE_CHARSET','UTF-8');
define('WEBSITE_ADDRESS','http://127.0.0.1/');
// Website default language (en/fr)
define('WEBSITE_LANGUAGE','fr');

// Database adress
define('DB_HOST','localhost');
// Database port
define('DB_PORT',3306);
// Database name
define('DB_NAME','');
// Database user
define('DB_USER','');
// Database password
define('DB_PASS','');

// Directory separator
define('DS', DIRECTORY_SEPARATOR);
// Root path
define('ROOT', __DIR__ . DS);
// Base path
define('BASEPATH', __DIR__);
// Environment type (development/production)
define('ENVIRONMENT', 'development');

// Path of application
define('APP', 'application' . DS);

// Path of core
define('CORE', 'core' . DS);

// Path of views
define('VIEWS', 'application' . DS . 'views' . DS);
// Path of models
define('MODELS', 'application' . DS . 'models' . DS);
// Path of controllers
define('CONTROLLERS', 'application' . DS . 'controllers' . DS);
// Path of helpers
define('HELPERS', 'application' . DS . 'helpers' . DS);

// Path of languages
define('LANG','languages' . DS);

// Path of styles
define('CSS', 'static' . DS . 'css' . DS);
// Path of fonts
define('FONTS', 'static' . DS . 'fonts' . DS);
// Path of javascripts
define('JS', 'static' . DS . 'js' . DS);

// URL list of styles libraries
define('LIB_CSS', []);

// URL list of javascripts libraries
define('LIB_JS', []);