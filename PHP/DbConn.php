<?php

// namespace Controller\DbConn;
// use PDO;

class DBConn {

	private $servername;
	private $username;
	private $password;
	private $dbname;
	private $conn;

	public function __construct ($servername, $username, $password, $dbname) {
		$this->servername = $servername;
		$this->username = $username;
		$this->password = $password;
		$this->dbname = $dbname;
		$this->connect();
	}

	public function __destruct() {
		$this->disconnect();
	}

	public function connect() {
		if (!$this->conn){
			try {
				$this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
				$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch (PDOException $e) {
				echo '<p class="db">'.'An error occurred talking to the DB. Error log below: '.'</p>' .'<br>'. $e->getMessage();
			}
			return $this->conn;

		} else {
			return $this->conn;
		}
	}

	public function disconnect() {
		if ($this->conn){
			$this->conn = null;
		}
	}
}

$newconn = new DBConn('localhost','xxxx','xxxx','xxx');
