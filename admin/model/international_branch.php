<?php
class international_branch extends dbclass{
	
	public function addBranch($data){
		
	
		
		$sql = "INSERT INTO " . DB_PREFIX . "international_branch SET  first_name = '" . $data['first_name'] . "', last_name = '" . $data['last_name'] . "', telephone = '" . $data['telephone'] . "', user_name = '".$data['user_name']."', ip = '" . $_SERVER['REMOTE_ADDR'] . "', status = '".(int)$data['status']."',date_added = NOW(),date_modify = NOW()";
	
		$this->query($sql);
		$branch_id = $this->getLastId();
	


		$salt = substr(md5(uniqid(rand(), true)), 0, 9);
		$sql1 = "INSERT INTO `" . DB_PREFIX . "account_master` SET user_type_id = '4', user_id = '" .(int)$branch_id. "', user_name = '" .$data['user_name']. "', salt = '" . $salt . "', password = '" . sha1($salt . sha1($salt . sha1($data['password']))) . "' , password_text = '" .$data['password']. "', email = '" .$data['email']. "', email1 = '" .$data['email1']. "',date_added = NOW()";
		$this->query($sql1);
		
		//insert address
		$this->query("INSERT INTO " . DB_PREFIX . "address SET user_type_id = '4', user_id = '" . (int)$branch_id . "', first_name = '" . $data['first_name'] . "', last_name = '" . $data['last_name'] . "', company = '', address = '" . $data['address'] . "'");
		
		$address_id = $this->getLastId();

		$this->query("UPDATE " . DB_PREFIX . "international_branch SET address_id = '" . (int)$address_id . "' WHERE international_branch_id = '" . (int)$branch_id . "'");
		

		print_r($branch_id);die;
		return $branch_id;
	}
	
	public function updateBranch($branch_id,$data){	
	
		
		//printr($data);die; 
	
		$sql = "UPDATE `" . DB_PREFIX . "international_branch` ib, `" . DB_PREFIX . "account_master` am SET ib.first_name = '" . $data['first_name'] . "', ib.last_name = '" . $data['last_name'] . "', ib.telephone = '" . $data['telephone'] . "', ib.user_name = '".$data['user_name']."',am.user_name = '".$data['user_name']."', am.email = '" . $data['email'] . "', ib.status = '".(int)$data['status']."',ib.date_modify = NOW(), am.date_modify = NOW() WHERE ib.international_branch_id = '".(int)$branch_id."' AND am.user_type_id = '4' AND am.user_id = '".(int)$branch_id."'";
		//echo $sql;die;
		$this->query($sql);				
	
		//printr($result);
		//die;
	
		$branch = $this->getBranch($branch_id);
		if (isset($data['password']) && $data['password']!='') {
			$salt = substr(md5(uniqid(rand(), true)), 0, 9);
			$this->query("UPDATE `" . DB_PREFIX . "account_master` SET salt = '" . $salt . "', password = '" . sha1($salt . sha1($salt . sha1($data['password']))) . "' , password_text = '" .$data['password']. "', email = '" .$data['email']. "',  date_modify = NOW() WHERE user_type_id = '4' AND user_id = '" .(int)$branch['international_branch_id']. "' AND user_name = '".$data['user_name']."'");
		}
		
		$this->query("UPDATE " . DB_PREFIX . "account_master SET status='".(int)$data['status']."',email1 = '" .$data['email1']. "' WHERE user_type_id = '4' AND  user_id = '" . (int)$branch['international_branch_id'] . "'");
		
		if($branch['address_id'] > 0){
			$this->query("UPDATE " . DB_PREFIX . "address SET first_name = '" . $data['first_name'] . "', last_name = '" . $data['last_name'] . "', company = '', address = '" . $data['address'] . "',  date_modify = NOW() WHERE user_type_id = '4' AND user_id = '".(int)$branch['international_branch_id']."' AND address_id = '".(int)$branch['address_id']."'");
		}else{
			$this->query("INSERT INTO " . DB_PREFIX . "address SET user_type_id = '4', user_id = '" . (int)$branch['international_branch_id'] . "', first_name = '" . $data['first_name'] . "', last_name = '" . $data['last_name'] . "', company = '', address = '" . $data['address'] . "'");
			$address_id = $this->getLastId();
			$this->query("UPDATE " . DB_PREFIX . "international_branch SET address_id = '" . (int)$address_id . "' WHERE international_branch_id = '" . (int)$branch['international_branch_id'] . "'");
		}
		//die;
	}
	
	public function getBranch($branch_id){
		$sql = "SELECT *, ib.international_branch_id,ib.first_name as ibfirst_name, ib.last_name as iblast_name FROM " . DB_PREFIX . "international_branch ib LEFT JOIN " . DB_PREFIX . "address addr ON (ib.address_id = addr.address_id) LEFT JOIN " . DB_PREFIX . "account_master am ON(am.user_name=ib.user_name) WHERE am.user_type_id = '4' AND ib.international_branch_id = '" .(int)$branch_id. "' AND am.user_id =ib.international_branch_id ";
		//echo $sql;die;
		$data = $this->query($sql);
		//printr($data->row);die;
		if($data->num_rows){
			return $data->row;
		}else{
			return false;
		}
	}
	
	public function getTotalBranch($filter_array=array()){
		$sql = "SELECT COUNT(*) as total FROM `" . DB_PREFIX . "international_branch` ib LEFT JOIN `" . DB_PREFIX . "account_master` am ON am.user_name=ib.user_name AND am.user_id = ib.international_branch_id AND am.user_type_id = '4' LEFT JOIN " . DB_PREFIX . "address addr ON (ib.address_id = addr.address_id) WHERE ib.is_delete = '0'";
		
			
		$data = $this->query($sql);
		return $data->row['total'];
	}
	
	public function getBranchs(){
		//$sql = "SELECT *,CONCAT(first_name,' ',last_name) as name FROM `" . DB_PREFIX . "client`";		
		$sql = "SELECT *,CONCAT(ib.first_name,' ',ib.last_name) as name,am.email FROM `" . DB_PREFIX . "international_branch` ib LEFT JOIN `" . DB_PREFIX . "account_master` am ON am.user_name=ib.user_name AND am.user_id = ib.international_branch_id AND am.user_type_id = '4' LEFT JOIN " . DB_PREFIX . "address addr ON (ib.address_id = addr.address_id)  WHERE ib.is_delete = '0'";
		
		
		$data = $this->query($sql);
		if($data->num_rows){
			return $data->rows;
		}else{
			return false;
		}
	}
	

	public function updateStatus($status,$data){
		//printr($data);die;
		if($status == 0 || $status == 1){
			$sql = "UPDATE `" . DB_PREFIX . "international_branch` SET status = '" .(int)$status. "',  date_modify = NOW() WHERE international_branch_id IN (" .implode(",",$data). ")";
			$this->query($sql);
			$this->query("UPDATE " . DB_PREFIX . "account_master SET status = '" .(int)$status. "' WHERE user_type_id = '4' AND user_id IN (" .implode(",",$data). ")");
		}elseif($status == 2){
			$sql = "UPDATE `" . DB_PREFIX . "international_branch` SET is_delete = '1', date_modify = NOW() WHERE international_branch_id IN (" .implode(",",$data). ")";
			$this->query($sql);
			//$sel_delete = "DELETE FROM account_master WHERE user_type_id = '4' AND user_id IN (" .implode(",",$data). ")";
			$sel_delete = "UPDATE `" . DB_PREFIX . "account_master` SET add_permission='', edit_permission='', delete_permission='', view_permission='' WHERE user_type_id = '4' AND user_id IN (" .implode(",",$data). ")";
			$this->query($sel_delete);
			
			$sql_select="SELECT * FROM employee WHERE user_type_id='4' AND user_id IN (" .implode(",",$data). ")";
			$select=$this->query($sql_select);
 
 			if($select->num_rows){
				foreach($select->rows as $row)
				{
					$sel_update = "UPDATE `" . DB_PREFIX . "account_master` SET add_permission='', edit_permission='', delete_permission='', view_permission='' WHERE user_type_id = '2' AND user_id=".$row['employee_id']."";
					$this->query($sel_update);
				}
			}
						
			
		}
	}
	


	
	
}
?>