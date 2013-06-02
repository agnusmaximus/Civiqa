<?php
	/* This class provides an easy interface to 
	 * querying databases, and executing Mysql statements.
	 */
	
	require_once('DatabaseInfo.php');
	
	class QueryObject {
		//core PDO object
		protected $pdo;
		protected $errorOut;
		
		/* Construction function */
		function __construct() {
			//Create this pdo core object
			try {
				$this->pdo = new pdo(DSN, USERNAME, PASSWORD);
			}
			catch (PDOException $e) {
			}
			$this->errorOut = false;
		}
		
		function enableErrorOutput() {
			$this->errorOut = true;
		}
		
		/* Executes a mysql command without returning anything 
		 * Usually used for insertions, etc. that return no value
		 */
		function exec($statement, $parameters = array()) {
			//USe mysql prepared statements for safety
			$prepared = $this->pdo->prepare($statement);
			
			//Execute
			$result = $prepared->execute($parameters);
						
			if ($this->errorOut) 
				$this->checkError($prepared);
			
			//Success or fail??
			return $result;
		}
		
		/* Queries a mysql database for information or for data */
		function query($statement, $parameters = array()) {
			$prepared = $this->pdo->prepare($statement);
			
			$prepared->execute($parameters);
			
			if ($this->errorOut) 
				$this->checkError($prepared);
			
			return $this->pdoStatementToArray($prepared);
		}
		
		/* This function takes a PDO Statement object, and gets data from it */
		function pdoStatementToArray($statement) {
			$array = $statement->fetchAll(PDO::FETCH_CLASS);

			return $array;
		}
		
		/* This function checks errors */
		function checkError($statement) {
			if (!$statement) {
				echo '!ERROR!';
				print_r($this->pdo->errorInfo());
			}
		}
	}
?>