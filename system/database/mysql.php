<?php
class mysql{

	private $link;
	
	public function __construct() {
		$hostname=DB_HOSTNAME;
		$username=DB_USERNAME;
		$password=DB_PASSWORD;
		$database=DB_DATABASE;
		
		$this->link = mysql_connect($hostname, $username, $password);
		
		if (!$this->link) {
			trigger_error('Error: Could not make a database link using ' . $username . '@' . $hostname);
		}

		if (!mysql_select_db($database, $this->link)) {
			trigger_error('Error: Could not connect to database ' . $database);
		}
	}
	
	public function query($sql){
		//echo $sql;die;
		$resource = mysql_query($sql, $this->link);
		if ($resource) {
			if (is_resource($resource)) {
				$i = 0;

				$data = array();

				while ($result = mysql_fetch_assoc($resource)) {
					$data[$i] = $result;

					$i++;
				}
				//printr($data);die;
				mysql_free_result($resource);

				$query = new stdClass();
				$query->row = isset($data[0]) ? $data[0] : array();
				$query->rows = $data;
				$query->num_rows = $i;

				unset($data);

				return $query;	
			} else {
				return true;
			}
		} else {
			trigger_error('Error: ' . mysql_error() . '<br />' . $sql);
			exit();
		}
		
	}
	
	public function escape($value) {
		if ($this->link) {
			return mysql_real_escape_string($value, $this->link);
		}
	}
	
	public function countAffected() {
		if ($this->link) {
			return mysql_affected_rows($this->link);
		}
	}
	
	public function getLastId() {
		if ($this->link) {
			return mysql_insert_id($this->link);
		}
	}

	public function __destruct() {
		if ($this->link) {
			mysql_close($this->link);
		}
	}
}
?>