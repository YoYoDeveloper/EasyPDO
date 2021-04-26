<?php

class EasyPDO {
	
	private $conn;
	private $queries = 0;
	
	public function __construct($host,$name,$user,$pass,$options=NULL,$encoding='utf8') {
		if(class_exists('PDO')) {
			try{
				if($options == NULL) {
					$options = [
						PDO::MYSQL_ATTR_INIT_COMMAND        => "SET NAMES {$encoding}",
						PDO::ATTR_PERSISTENT                => true, // Long connection
						PDO::ATTR_EMULATE_PREPARES          => false, // turn off emulation mode for "real" prepared statements
						PDO::ATTR_DEFAULT_FETCH_MODE        => PDO::FETCH_ASSOC, //make the default fetch be an associative array
						PDO::MYSQL_ATTR_USE_BUFFERED_QUERY  => true,
						PDO::ATTR_ERRMODE                   => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
					];
				}
				else {
					$options = $options;
				}
				$this->conn = new PDO("mysql:host={$host};dbname={$name}",$user,$pass,$options);
				$this->conn -> exec("SET character_set_client='{$encoding}',character_set_connection='{$encoding}',character_set_results='{$encoding}';");
				return $this->conn;
			}
			catch(PDOException $e) {
				exit($e->getMessage());
			}
		}
		else {
			exit('PDO is not installed on this server.');
		}
	}
	
	public function query($query, $params=NULL) {

		if(!isSet($query)){ $query=NULL; }
		if(!isSet($params)){ $params=NULL; }
		
		if($this->conn instanceof PDO) {
			if($query!=NULL) {
				$stmt = $this->conn -> prepare($query);
				if($params != NULL) {
					foreach($params as $param => &$value) {
						
						$varType = ((is_null($value) ? \PDO::PARAM_NULL : is_bool($value)) ? \PDO::PARAM_BOOL : is_int($value)) ? \PDO::PARAM_INT : \PDO::PARAM_STR;
						
						$stmt -> bindParam($param, $value, $varType);
					}
				}
				$stmt -> execute();
				$this -> queries++;
				return  $stmt; 
			}
			else {
				exit("Ohh, come on! Really? What do you want to do with this function if you not make a query?");
			}
		}
		else {
			exit('Why you bully this class? That thing you set there is not initiated by the PDO, so I think it\'s not a database. Do something good for this project and put a database ... You Mother Fucker.');
		}

	}
	
	public function queries() {
		return $this->queries;
	}
	
}

?>
