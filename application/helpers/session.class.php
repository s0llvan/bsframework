<?php

class Session
{
	public static function get($key) {
		return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : null;
	}
	public static function set($key, $value) {
		$_SESSION[$key] = $value;
	}
	public static function pull($key) {
		$_SESSION[$key] = '';
	}
	public static function clean() {
		$_SESSION = array();
		session_destroy();
	}
}