<?php
/*
 * MySQL class for BSFramework
 *
 * @package BSFramework
 * @version 1.0
 */
class MySQL {
	private $host,
            $port,
	        $user,
	        $pass,
	        $db,
	        $sql,
            $query;
    
    private $fields = [],
            $values = [];
    /*
     * Connect to MySQL Database
     *
     * @params {string} : Database
     * @params {string} : User
     * @params {string} : Password
     * @params {string} : Host
     * @params {int}    : Port
     */
	function __construct($db, $user='root', $pass='', $host='127.0.0.1',$port=3306) {
		$this->db = $db;
		$this->user = $user;
		$this->pass = $pass;
		$this->host = $host;
        $this->port = $port;
        
		$this->connect();
	}
	private function connect() {
		$this->sql = new PDO('mysql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->db, $this->user, $this->pass);
	}
    /*
     * Select statement
     *
     * @params {string} : Fields
     */
    public function select($fields) {
        $this->query = "SELECT $fields ";
        return $this;
    }
    /*
     * From
     *
     * @params {string} : Table
     */
    public function from($table) {
        $this->query .= "FROM $table";
        return $this;
    }
    /*
     * Where
     *
     * @params {string} : Field
     * @params {string} : Value or Sign
     * @params {string} : Value (optionnal)
     */
    public function where($field, $param1, $param2=null) {
        if(!strpos($this->query, 'WHERE'))
            $this->query .= " WHERE $field ";
        else
            $this->query .= " AND $field ";
        if(isset($param2)) {
            if(is_string($param2))
                $this->query .= "$param1 '" . $param2 . "'";
            else
                $this->query .= "$param1 $param2";
        } else {
            if(is_string($param1))
                $this->query .= "LIKE '" . $param1 . "'";
            else
                $this->query .= "= " . $param1;
        }
        return $this;
    }
    /*
     * Group By
     *
     * @params {string} : Field
     */
    public function group($field) {
        if(!strpos($this->query, 'GROUP BY'))
            $this->query .= " GROUP BY $field " . (isset($type) ? $type : "");
        else
            $this->query .= ", $field";
        return $this;
    }
    /*
     * Order By
     *
     * @params {string} : Field
     * @params {string} : Type
     */
    public function order($field, $type=null) {
        if(!strpos($this->query, 'ORDER BY'))
            $this->query .= " ORDER BY $field " . (isset($type) ? $type : "");
        else
            $this->query .= ", $field " . (isset($type) ? $type : "");
        return $this;
    }
    /*
     * Limit
     *
     * @params {string} : Number
     */
    public function limit($number) {
        $this->query .= " LIMIT $number";
        return $this;
    }
    /*
     * Offset
     *
     * @params {string} : Number
     */
    public function offset($number) {
        $this->query .= " OFFSET $number";
        return $this;
    }
    /*
     * Get
     *
     * @return {object} : Object of query result
     */
    public function get() {
        $exec = $this->sql->prepare($this->query);
        $exec->execute();
        return $exec->fetch(PDO::FETCH_OBJ);
    }
    /*
     * Get All
     *
     * @return {array} : Array of object query result
     */
    public function getAll() {
        $exec = $this->sql->prepare($this->query);
        $exec->execute();
        return $exec->fetchAll(PDO::FETCH_OBJ);
    }
    /*
     * Insert statement
     *
     * @params {string} : Table
     */
    public function insert($table) {
        $this->query = "INSERT INTO $table";
        return $this;
    }
    /*
     * Update statement
     *
     * @params {string} : Table
     */
    public function update($table) {
        $this->query = "UPDATE $table";
        return $this;
    }
    /*
     * Delete statement
     *
     * @params {string} : Table
     */
    public function delete($table) {
        $this->query = "DELETE FROM $table";
        return $this;
    }
    /*
     * Set field and value in query
     *
     * @params {string} : Field
     * @params {string} : Value
     */
    public function set($field, $value) {
        array_push($this->fields, $field);
        array_push($this->values, $value);
        return $this;
    }
    /*
     * Execute query of insert, update or delete statement
     *
     * @return {int} : Last insert ID
     */
    public function execute() {
        if(strpos($this->query, 'INSERT INTO') !== false) {
            $fields = '';
            $values = '';
            for($i = 0;$i < count($this->fields);$i++) {
                $field = $this->fields[$i];
                $value = $this->values[$i];

                $fields .= $field . (($i < count($this->fields) - 1) ? ', ' : '');
                $values .= (is_string($value) ? "'".$value."'" : $value) . (($i < count($this->values) - 1) ? ', ' : '');
            }
            $this->query .= "($fields) VALUES($values)";
        } elseif (strpos($this->query, 'UPDATE') !== false) {
            $line = '';
            
            for($i = 0;$i < count($this->fields);$i++) {
                $field = $this->fields[$i];
                $value = $this->values[$i];
                $line .= "$field=" . (is_string($value) ? "'".$value."'" : $value) . (($i < count($this->values) - 1) ? ', ' : '');
             }
            
            $init = explode(" ", $this->query);
            
            $end = preg_replace('/' . $init[0] . '/', '', $this->query, 1);
            $end = preg_replace('/' . $init[1] . '/', '', $end, 1);
            
            $this->query = $init[0] . ' ' . $init[1] . ' SET ' . $line . $end;
        }
        $exec = $this->sql->prepare($this->query);
        $exec->execute();
        return $this->sql->lastInsertId();
    }
    public function drop($table) {
        $this->query = "DROP $table";
        $exec = $this->sql->prepare($this->query);
        $exec->execute();
    }
    /*
     * Check connected status
     */
    public function isConnected()
    {
        if($this->sql != null)
            return true;
        return false;
    }
    /*
     * Close MySQL Connection
     */
	function __destruct() {
		$this->closeConnection();
	}
	private function closeConnection(){
		$sql = null;
	}
}