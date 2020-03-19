<?php
class dbclass {
	
	private $link;
	
	public function __construct() {
		$hostname=DB_HOSTNAME;
		$username=DB_USERNAME;
		$password=DB_PASSWORD;
		$database=DB_DATABASE;
		
		$this->link = mysqli_connect($hostname,$username,$password,$database);

		// Check connection
		if (!$this->link)
		{
		  die("Connection error: " . mysqli_connect_errno());
		}
	}
	
	
	public function query($sql){
		//echo $sql;die;
		$resource = mysqli_query($this->link, $sql);
		if ($resource) {
			if (is_object($resource)) {
				$i = 0;

				$data = array();

				while ($result = mysqli_fetch_assoc($resource)) {
					$data[$i] = $result;

					$i++;
				}
				//printr($data);die;
				ini_set('memory_limit', '-1');
				//ini_set('max_execution_time', 300);
				mysqli_free_result($resource);

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
			trigger_error('Error : ' . mysqli_error($this->link) . '<br />' . $sql);
			exit();
		}
		
	}
	
	public function escape($val){
		if ($this->link) {
			return mysqli_real_escape_string($this->link,$val);
		}
	}
	
	public function getLastId() {
		if ($this->link) {
			return mysqli_insert_id($this->link);
		}
	}

	public function __destruct() {
		if ($this->link) {
			mysqli_close($this->link);
		}
	}
}
?>