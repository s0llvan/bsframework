<?php

class File
{
	public static function get($name) {
		return (file_exists($name) ? file_get_contents($name) : null);
	}
	public static function set($name, $content) {
		file_put_contents($name, $content);
	}
	public static function pull($name) {
		if(file_exists($name)) {
			unlink($name);
		}
	}
}