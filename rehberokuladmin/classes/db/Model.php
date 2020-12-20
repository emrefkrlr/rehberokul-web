<?php
ini_set('memory_limit', '-1');
abstract class Model {
    public $databaseHandler;
    public $statement;
    protected $queryString;
    protected $bindValues;
    protected $rowCount;
    protected static $BIND_COUNT = 0; //to create unique bind parameters like value0, value1 in a query
    
    public function __construct() {
        $this->bindValues = array();
        $options = array(
			PDO::ATTR_PERSISTENT	=> true,
			PDO::ATTR_ERRMODE		=> PDO::ERRMODE_EXCEPTION
		);
		// Create new PDO
		try {
			$this->databaseHandler 
            = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.';charset=utf8', DB_USER, DB_PASS, $options);
		} catch(PDOEception $e){
			$this->error = $e->getMessage();
		}
    }
    
    public function query($query) {
        $this->statement = $this->databaseHandler->prepare($query);
    }
    
    public function bind($param, $value) {
        $this->bindValues += array($param=>$value);
    }
    
    public function execute() {
        $this->queryString = $this->queryString.';'; //end of the query
        $this->query($this->queryString); // prepares query
        $this->statement->execute($this->bindValues); // executes query
        self::$BIND_COUNT = 0;
        $this->bindValues = array();
    }
    
    public function resultSet() {
        $this->execute(); // calls execute method
        return $this->statement->fetchAll(PDO::FETCH_ASSOC); // returns result set
    }
    
    public function single() {
        $this->execute(); // calls execute method
        return $this->statement->fetch(PDO::FETCH_ASSOC); // returns single result
    }
    
    public function lastInsertId(){
	return $this->databaseHandler->lastInsertId();
    }
    
    public function getRowCount() {
        return $this->rowCount;
    }
    
    
}