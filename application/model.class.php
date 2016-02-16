<?php
/*
 * Model class for BSFramework
 *
 * @package BSFramework
 * @version 1.0
 */
abstract class Model
{
    protected $db;
    
	public function __construct() {
		$this->db = new MySQL(DB_NAME, DB_USER, DB_PASS, DB_HOST, DB_PORT);
	}
}