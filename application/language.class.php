<?php
/**
 * Language class for BSFramework
 *
 * @package BSFramework
 * @version 1.0
 */
class Language
{
	private $json;

	public function __construct($lang) {
	    $file 		= file_get_contents(LANG . $lang . '.json');
	    $this->json = json_decode($file);
	}

	public function get() {
	    if (func_num_args() > 0 ) {
	    	$string = $this->findby(func_get_args()[0]);
	        for($i=0;$i<count(func_get_args());$i++) {
	        	$string = str_replace("{".($i - 1)."}", func_get_args()[$i], $string);
	        }
	        return $string;
	    }
	    return null;
	}

	private function findby($id) {
		foreach(array_keys(get_object_vars($this->json)) as $obj) {
			if($obj==$id) {
				return get_object_vars($this->json)[$obj];
			}
		}
	}
}