<?php

class Json
{
	public static function get($json) {
		return json_decode($json);
	}
	public static function set($content) {
		return json_encode($content);
	}
}