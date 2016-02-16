<?php
/*
 * Functions list for BSFramework
 *
 * @package BSFramework
 * @version 1.0
 */
function __autoload($className) { 
    if (file_exists(ROOT . CORE . strtolower($className) . '.php')) {
        require_once(ROOT . CORE . strtolower($className) . '.php');
    } else if (file_exists(ROOT . CONTROLLERS . strtolower($className) . '.php')) {
        require_once(ROOT . CONTROLLERS . strtolower($className) . '.php');
    } else if (file_exists(ROOT . MODELS . $className . '.php')) {
        require_once(ROOT . MODELS . $className . '.php');
    } else if (file_exists(ROOT . APP . $className . '.php')) {
        require_once(ROOT . APP . $className . '.php');
    }
}

function __autoload_lib_css($dir, $depth=0) {
    $scan = glob("$dir/*");
    foreach ($scan as $path) {
        if (preg_match('/\.css/', $path)) {
            $path = str_replace(ROOT,WEBSITE_ADDRESS,$path);
            echo "<link rel='stylesheet' href='" . $path . "' type='text/css' />";
        } elseif (is_dir($path)) {
            __autoload_lib_css($path, $depth+1);
        }
    }
}

function __autoload_lib_js($dir, $depth=0) {
    $scan = glob("$dir/*");
    foreach ($scan as $path) {
        if (preg_match('/\.js/', $path)) {
            $path = str_replace(ROOT,WEBSITE_ADDRESS,$path);
            echo "<script src='" . $path . "'></script>";
        } elseif (is_dir($path)) {
            __autoload_lib_js($path, $depth+1);
        }
    }
}

function __autoload_php($dir, $depth=0) {
    $scan = glob("$dir/*");
    foreach ($scan as $path) {
        if (preg_match('/\.php/', $path)) {
            require($path);
        } elseif (is_dir($path)) {
            __autoload_php($path, $depth+1);
        }
    }
}

function __autoload_url_lib_css() {
    foreach(LIB_CSS as $url) {
        echo "<link rel='stylesheet' href='" . $url . "' type='text/css' />"; 
    }
}

function __autoload_url_lib_js() {
    foreach(LIB_JS as $url) {
        echo "<script src='" . $url . "'></script>";
    }
}

// Close application with message
function closeWithException($message) {
    $bt = debug_backtrace();
    $caller = array_shift($bt);
    echo 'File: ' . $caller['file'] . '</br>';
    echo 'Line: ' . $caller['line'] . '</br>';
    echo '<b>'.$message.'</b>';
    exit();
}

// Generate and assign a uniq token
function uniqToken() {
    $token = uniqid(rand(), true);
    $token_time = time();
    Session::set('sys_token', $token);
    Session::set('sys_token_time', $token_time);
    return $token;
}