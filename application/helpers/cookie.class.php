<?php

class Cookie
{
	public static function get($key) {
		return $_COOKIE[$key];
	}
	public static function set($key, $value, $time=null) {
		if(empty($time)) {
			$time = time()+365*24*3600;
		}
		setcookie($key, $value, $time, null, null, false, true);
	}
	public static function pull($key) {
		setcookie($key, null, null, null, null, false, true);
	}
	public static function clean() {
		$keys = array_keys($_COOKIE);
		foreach($keys as $key) {
			if($key != 'PHPSESSID') {
				setcookie($key, null, null, null, null, false, true);
			}
		}
	}
}