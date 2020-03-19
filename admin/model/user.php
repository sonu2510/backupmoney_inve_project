<?php
class user extends dbclass{
	
	public function checkUserNamePassword($user_name,$password){
		//$sql = "SELECT * FROM " . DB_PREFIX . "account_master WHERE user_name = '" .$user_name. "' AND 	password_text = '" .$password. "'";
		//$sql = "SELECT * FROM " . DB_PREFIX . "user WHERE user_name = '" . $user_name . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $password . "'))))) OR password = '" . md5($password) . "') ";
		//$sql = "SELECT * FROM " . DB_PREFIX . "user u, account_master am WHERE u.user_name = '" . $user_name . "' AND am.user_name = '" . $user_name . "' AND (am.password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $password . "'))))) OR am.password = '" . md5($password) . "')";
		$sql = "SELECT user_type_id,user_id FROM " . DB_PREFIX . "account_master WHERE user_name = '" . $user_name . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $password . "'))))) OR password = '" . md5($password) . "')";
		
		//for first time admin login
		//$sql = "SELECT user_type_id,user_id FROM " . DB_PREFIX . "account_master WHERE user_name = '" . $user_name . "' AND  password_text = '" . $password . "'";
		//echo $sql;die;
		$data = $this->query($sql);
	//	printr($data);die;
		if($data->num_rows){
			if($data->row['user_type_id'] == 2)
			{
				$login = $this->query("SELECT *,e.user_type_id as admin_type_id FROM " . DB_PREFIX . "employee e, account_master am WHERE e.user_name = '" . $user_name . "' AND am.user_name = '" . $user_name . "' AND (am.password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $password . "'))))) OR am.password = '" . md5($password) . "') AND e.employee_id = '".(int)$data->row['user_id']."'");
			}
			
			elseif($data->row['user_type_id'] == 3)
			{
				$login = $this->query("SELECT * FROM " . DB_PREFIX . "client c, account_master am WHERE c.user_name = '" . $user_name . "' AND am.user_name = '" . $user_name . "' AND (am.password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $password . "'))))) OR am.password = '" . md5($password) . "') AND c.client_id = '".(int)$data->row['user_id']."'");
			}
			
			elseif($data->row['user_type_id'] == 4)
			{
				$login = $this->query("SELECT * FROM " . DB_PREFIX . "international_branch ib, account_master am WHERE ib.user_name = '" . $user_name . "' AND am.user_name = '" . $user_name . "' AND (am.password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $password . "'))))) OR am.password = '" . md5($password) . "') AND ib.international_branch_id = '".(int)$data->row['user_id']."'");
			}
			elseif($data->row['user_type_id'] == 5)
			{
				$login = $this->query("SELECT * FROM " . DB_PREFIX . "associate a, account_master am WHERE a.user_name = '" . $user_name . "' AND am.user_name = '" . $user_name . "' AND (am.password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $password . "'))))) OR am.password = '" . md5($password) . "') AND a.associate_id = '".(int)$data->row['user_id']."'");
			}
			else
			{
				$login = $this->query("SELECT * FROM " . DB_PREFIX . "user u, account_master am WHERE u.user_name = '" . $user_name . "' AND am.user_name = '" . $user_name . "' AND (am.password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $password . "'))))) OR am.password = '" . md5($password) . "') AND u.user_id = '".(int)$data->row['user_id']."' ");
				//$login = $this->query("SELECT * FROM " . DB_PREFIX . "user u, account_master am WHERE u.user_name = '" . $user_name . "' AND am.user_name = '" . $user_name . "' AND am.password_text = '" . $password . "' AND u.user_id = '".(int)$data->row['user_id']."' ");
			}
		//	printr($login);die;
			
			if($login->num_rows ){
				
				$ip = $_SERVER['REMOTE_ADDR'];
				$browser = $_SERVER['HTTP_USER_AGENT'];
				
				$history = $this->query("INSERT INTO " . DB_PREFIX . "login_history SET user_id = '".$login->row['user_id']."',user_type_id = '".$login->row['user_type_id']."',login_status=1,ip='".$ip."',browser='".$browser."',last_login=NOW(),status=1 ");
				
				$last_history = $this->query("SELECT MAX(login_history_id) as last_login_id FROM " . DB_PREFIX . "login_history");
				$_SESSION['history_id'] = $last_history->row['last_login_id'];
				//echo $_SESSION['history_id'];die;
				return $login->row;
			}else{
				return false;
			}
			
		}else{
			return false;
		}
	}
	
	public function getUser($user_type_id,$user_id){
		if($user_type_id == 1){
			$sql = "SELECT *,u.first_name as first_name,u.last_name as last_name FROM `" . DB_PREFIX . "user` u LEFT JOIN `" . DB_PREFIX . "account_master` am ON(am.user_name=u.user_name) LEFT JOIN `" . DB_PREFIX . "address` ad ON(ad.user_id=u.user_id) WHERE u.user_id = '" .(int)$user_id. "' AND am.user_id = '" .(int)$user_id. "' AND am.user_type_id = '".(int)$user_type_id."'";
			
			
			$data = $this->query($sql);
			
		}elseif($user_type_id == 2){
			
			$sql = "SELECT * FROM `" . DB_PREFIX . "employee` e LEFT JOIN `" . DB_PREFIX . "account_master` am ON(am.user_name=e.user_name) LEFT JOIN `" . DB_PREFIX . "address` ad ON(ad.address_id=e.address_id) WHERE e.employee_id = '" .(int)$user_id. "' AND am.user_id = '" .(int)$user_id. "' AND am.user_type_id = '".(int)$user_type_id."'";
			$data = $this->query($sql);
		}elseif($user_type_id == 3){
			
			$sql = "SELECT * FROM `" . DB_PREFIX . "client` c LEFT JOIN `" . DB_PREFIX . "account_master` am ON(am.user_name=c.user_name) LEFT JOIN `" . DB_PREFIX . "address` ad ON(ad.address_id=c.address_id) WHERE c.client_id = '" .(int)$user_id. "' AND am.user_id = '" .(int)$user_id. "' AND am.user_type_id = '".(int)$user_type_id."'";
			
			$data = $this->query($sql);
		}elseif($user_type_id == 4){
			$sql = "SELECT * FROM `" . DB_PREFIX . "international_branch` ib LEFT JOIN `" . DB_PREFIX . "account_master` am ON(am.user_name=ib.user_name) LEFT JOIN `" . DB_PREFIX . "address` ad ON(ad.address_id=ib.address_id) WHERE ib.international_branch_id = '" .(int)$user_id. "' AND am.user_id = '" .(int)$user_id. "' AND am.user_type_id = '".(int)$user_type_id."'";
							
			$data = $this->query($sql);

		}elseif($user_type_id == 5){
			$sql = "SELECT * FROM `" . DB_PREFIX . "associate` a LEFT JOIN `" . DB_PREFIX . "account_master` am ON(am.user_name=a.user_name)  LEFT JOIN `" . DB_PREFIX . "address` ad ON(ad.address_id=a.address_id) WHERE a.associate_id = '" .(int)$user_id. "' AND am.user_id = '" .(int)$user_id. "' AND am.user_type_id = '".(int)$user_type_id."'";
			$data = $this->query($sql);
		}else{
			$data = '';
		}
		
		if($data && $data->num_rows){
			return $data->row;
		}else{
			return false;
		}
	}
	
	public function insertDuration($login_id){
		
		$data = $this->query("SELECT last_login FROM `" . DB_PREFIX . "login_history` WHERE login_history_id='".$login_id."'");
		$login_time = date("Y-m-d H:i:s",strtotime($data->row['last_login']));
		$current_time = date("Y-m-d H:i:s");
		//echo $current_time . "===" .$login_time;die; 
		$duration = strtotime($current_time) - strtotime($login_time);
		
		$days    = floor($duration / 86400);
		$hours   = floor(($duration - ($days * 86400)) / 3600);
		$minutes = floor(($duration - ($days * 86400) - ($hours * 3600))/60);
		$seconds = floor(($duration - ($days * 86400) - ($hours * 3600) - ($minutes*60)));
		
		$duration_text = '';
		if($days>0){
			$duration_text .= $days ." Days,";	
		}
		if($hours>0){
			$duration_text .= $hours ."Hours,";
		}
		$duration_text .= $minutes." Miniutes,".$seconds." Seconds";
		
		
		//echo $days."===".$hours."===".$minutes."===".$seconds;die;
		$this->query("UPDATE `" . DB_PREFIX . "login_history` SET login_duration='".$duration_text."',login_status=0 WHERE login_history_id='".$login_id."'");
		
	}
	
	public function updateProfile($user_type_id,$user_id,$data){
		//printr($data);die;
		

		if($user_type_id == 1){
			$sql = "UPDATE `" . DB_PREFIX . "user` u, `" . DB_PREFIX . "account_master` am SET u.first_name = '" . $data['first_name'] . "', u.last_name = '" . $data['last_name'] . "', u.user_name = '".$data['user_name']."',u.email_signature='".$data['email_signature']."', am.user_name = '".$data['user_name']."', am.email = '" . $data['email'] . "', u.date_modify = NOW(), am.date_modify = NOW() WHERE u.user_id = '".(int)$user_id."' AND am.user_type_id = '".(int)$user_type_id."' AND am.user_id = '".(int)$user_id."'";
			$this->query($sql);
			
			$user_details = $this->getUser(1,$user_id);
								
			
		}elseif($user_type_id == 2){
			$sql = "UPDATE `" . DB_PREFIX . "employee` e, `" . DB_PREFIX . "account_master` am SET e.first_name = '" . $data['first_name'] . "', e.last_name = '" . $data['last_name'] . "', e.user_name = '".$data['user_name']."',e.email_signature='".$data['email_signature']."', am.user_name = '".$data['user_name']."', am.email = '" . $data['email'] . "', e.date_modify = NOW(), am.date_modify = NOW() WHERE e.employee_id = '".(int)$user_id."' AND am.user_type_id = '".(int)$user_type_id."' AND am.user_id = '".(int)$user_id."'";
			$this->query($sql);
			
			$user_details = $this->getUser(2,$user_id);
			
		}elseif($user_type_id == 3){
			$sql = "UPDATE `" . DB_PREFIX . "client` c, `" . DB_PREFIX . "account_master` am SET c.first_name = '" . $data['first_name'] . "', c.last_name = '" . $data['last_name'] . "', c.user_name = '".$data['user_name']."',c.email_signature='".$data['email_signature']."', am.user_name = '".$data['user_name']."', am.email = '" . $data['email'] . "', c.date_modify = NOW(), am.date_modify = NOW() WHERE c.client_id = '".(int)$user_id."' AND am.user_type_id = '".(int)$user_type_id."' AND am.user_id = '".(int)$user_id."'";
			$this->query($sql);
			
			$user_details = $this->getUser(3,$user_id);
			
		}elseif($user_type_id == 4){
			$sql = "UPDATE `" . DB_PREFIX . "international_branch` ib, `" . DB_PREFIX . "account_master` am SET ib.first_name = '" . $data['first_name'] . "', ib.last_name = '" . $data['last_name'] . "', ib.user_name = '".$data['user_name']."',ib.email_signature='".$data['email_signature']."', am.user_name = '".$data['user_name']."', am.email = '" . $data['email'] . "', ib.date_modify = NOW(), am.date_modify = NOW() WHERE ib.international_branch_id = '".(int)$user_id."' AND am.user_type_id = '".(int)$user_type_id."' AND am.user_id = '".(int)$user_id."'";
			$this->query($sql);
			
			$user_details = $this->getUser(4,$user_id);
			
		}elseif($user_type_id == 5){
			$sql = "UPDATE `" . DB_PREFIX . "associate` a, `" . DB_PREFIX . "account_master` am SET a.first_name = '" . $data['first_name'] . "', a.last_name = '" . $data['last_name'] . "', a.user_name = '".$data['user_name']."',a.email_signature='".$data['email_signature']."', am.user_name = '".$data['user_name']."', am.email = '" . $data['email'] . "', a.date_modify = NOW(), am.date_modify = NOW() WHERE a.associate_id = '".(int)$user_id."' AND am.user_type_id = '".(int)$user_type_id."' AND am.user_id = '".(int)$user_id."'";
			$this->query($sql);
			
			$user_details = $this->getUser(5,$user_id);
		}
		
		if (isset($data['password']) && !empty($data['password']) && $user_type_id > 0 ) {
			$salt = substr(md5(uniqid(rand(), true)), 0, 9);
			$sql1 = "UPDATE `" . DB_PREFIX . "account_master` SET salt = '" . $salt . "', password = '" . sha1($salt . sha1($salt . sha1($data['password']))) . "' , password_text = '" .$data['password']. "', date_modify = NOW() WHERE user_name = '".$data['user_name']."' AND user_type_id = '".$user_type_id."' AND user_id = '" .(int)$user_id. "'";
			$this->query($sql1);
		}
		
		
		$this->query("UPDATE " . DB_PREFIX . "address SET first_name = '" . $data['first_name'] . "', last_name = '" . $data['last_name'] . "', company = '', address = '" . $data['address'] . "', city = '" . $data['city'] . "', postcode = '" . $data['postcode'] . "', state = '" . $data['state'] . "', country_id = '" . (int)$data['country_id'] . "', date_modify = NOW() WHERE user_type_id = '".$user_type_id."' AND user_id = '".(int)$user_id."' AND address_id = '".(int)$user_details['address_id']."'");
				
	}
	

	
	public function getUsers(){
				
		$sql = "SELECT u.*,am.email,CONCAT(first_name,' ',last_name) as name FROM `" . DB_PREFIX . "user` u LEFT JOIN " . DB_PREFIX ."account_master am ON am.user_id=u.user_id WHERE am.user_type_id = '1' AND u.is_delete=0 ";

	
		//echo $sql;die;
		$data = $this->query($sql);
		if($data->num_rows){
			return $data->rows;
		}else{
			return false;
		}
	}
	public function addUser($data){
		//printr($data);die;
		
		$salt = substr(md5(uniqid(rand(), true)), 0, 9);
		$sql = "INSERT INTO `" . DB_PREFIX . "user` SET 	first_name = '" .$data['firstname']. "', last_name = '" .$data['lastname']. "',   user_name = '" .$data['username']. "', telephone = '" . $data['telephone'] . "', ip = '".$_SERVER['REMOTE_ADDR']."', date_added = NOW()";
		//echo $sql;die;
		$this->query($sql);
		$last_id = $this->getLastId();
		//user_name = '" .$data['username']. "', salt = '" . $salt . "', password = '" . sha1($salt . sha1($salt . sha1($data['password']))) . "' , password_text = '" .$data['password']. "', email = '" .$data['email']. "',
		$sql1 = "INSERT INTO `" . DB_PREFIX . "account_master` SET user_type_id = '1', user_id = '" .(int)$last_id. "', user_name = '" .$data['username']. "', salt = '" . $salt . "', password = '" . sha1($salt . sha1($salt . sha1($data['password']))) . "' , password_text = '" .$data['password']. "', email = '" .$data['email']. "', date_added = NOW()";
		$this->query($sql1);
		
		
		$this->query("INSERT INTO " . DB_PREFIX . "address SET user_type_id = '1', user_id = '" . (int)$last_id . "', first_name = '" . $data['first_name'] . "', last_name = '" . $data['last_name'] . "', company = '', address = '" . $data['address'] . "'");

		
		return $last_id;
 	}
	
	public function updateUser($user_id,$data){
		//printr($data);die;
		//echo $user_id;die;
		//echo $sql;die;
		
		$sql = "UPDATE `" . DB_PREFIX . "user` u, `" . DB_PREFIX . "account_master` am SET u.first_name = '" . $data['firstname'] . "', u.last_name = '" . $data['lastname'] . "',  u.ip = '".$_SERVER['REMOTE_ADDR']."', u.status = '" .$data['status']. "', u.telephone = '" . $data['telephone'] . "', u.user_name = '".$data['username']."', am.user_name = '".$data['username']."', am.email = '" . $data['email'] . "',  u.date_modify = NOW(), am.date_modify = NOW() WHERE u.user_id = '".(int)$user_id."' AND am.user_type_id = '1' AND am.user_id = '".(int)$user_id."'";
		
		$this->query($sql);
		
		/*if (isset($data['username']) && !empty($data['username'])) {
			$sql1 = "UPDATE `" . DB_PREFIX . "account_master` SET user_name = '" . $data['username'] . "', date_modify = NOW() WHERE user_type_id = '1' AND user_id = '" .(int)$user_id. "'";
			$this->query($sql1);
		}*/
		
		$user_details = $this->getUser(1,$user_id);
		
		if (isset($data['password']) && !empty($data['password'])) {
			
			$salt = substr(md5(uniqid(rand(), true)), 0, 9);
			//$this->query("UPDATE `" . DB_PREFIX . "user` SET  salt = '" . $salt . "', password = '" . sha1($salt . sha1($salt . sha1($data['password']))) . "', password_text = '" .$data['password']. "' WHERE user_id = '" . (int)$user_id . "'");
			//$sql1 = "INSERT INTO `" . DB_PREFIX . "account_master` SET user_type_id = '1', user_id = '" .(int)$last_id. "', user_name = '" .$data['username']. "', salt = '" . $salt . "', password = '" . sha1($salt . sha1($salt . sha1($data['password']))) . "' , password_text = '" .$data['password']. "', email = '" .$data['email']. "', date_added = NOW()";
			$sql1 = "UPDATE `" . DB_PREFIX . "account_master` SET salt = '" . $salt . "', password = '" . sha1($salt . sha1($salt . sha1($data['password']))) . "' , password_text = '" .$data['password']. "', email = '" .$data['email']. "', date_modify = NOW() WHERE user_type_id = '1' AND user_id = '" .(int)$user_id. "'";
			$this->query($sql1);
		}
		
		if($user_details['address_id'] > 0){
				
			$this->query("UPDATE " . DB_PREFIX . "address SET first_name = '" . $data['firstname'] . "', last_name = '" . $data['lastname'] . "', company = '', address = '" . $data['address'] . "',  date_modify = NOW() WHERE user_type_id = '1' AND user_id = '".(int)$user_id."' AND address_id = '".(int)$user_details['address_id']."'");
		
		}else{
	
			$this->query("INSERT INTO " . DB_PREFIX . "address SET user_type_id = '1', user_id = '" . (int)$user_id . "', first_name = '" . $data['firstname'] . "', last_name = '" . $data['lastname'] . "', company = '', address = '" . $data['address'] . "'");
			
		}
 	}
	

	
	
	//permission
	public function menu_combo($selected = ''){
		$sql = "SELECT * FROM `" . DB_PREFIX . "admin_menu` WHERE parent_id != '0' AND status = '1' ORDER BY name ASC ";
		$data = $this->query($sql);
		//printr($data);die;
		if($data->num_rows){
			$readval = $data->rows;
			$selid = '';
			if(!empty($selected)){
				$selid = explode(",",$selected);
			}
			for($i=0;$i<$data->num_rows;$i++)
			{
				 if(!empty($selid)){
					 if(in_array($readval[$i]['admin_menu_id'],$selid)){
						 $sele = 'selected="selected"';
					 }else{
						 $sele = '';
					 }
				 }else{
					 $sele = '';
				 }
				?>
				<option value="<?php echo $readval[$i]['admin_menu_id']; ?>" <?php echo  $sele;?> > - <?php echo ucwords($readval[$i]['name']);?></option>
				<?php
			}
		}
	}
	
	//new design
	public function getPermissionMenu($selected = ''){
		$sql = "SELECT * FROM `" . DB_PREFIX . "admin_menu` WHERE parent_id != '0' AND status = '1' ORDER BY name ASC ";
		$data = $this->query($sql);
		//printr($data);die;
		if($data->num_rows){
			$readval = $data->rows;
			$selid = '';
			if(!empty($selected)){
				$selid = explode(",",$selected);
			}
			for($i=0;$i<$data->num_rows;$i++)
			{
				 if(!empty($selid)){
					 if(in_array($readval[$i]['admin_menu_id'],$selid)){
						 $sele = 'selected="selected"';
					 }else{
						 $sele = '';
					 }
				 }else{
					 $sele = '';
				 }
				?>
				<option value="<?php echo $readval[$i]['admin_menu_id']; ?>" <?php echo  $sele;?> > - <?php echo ucwords($readval[$i]['name']);?></option>
				<?php
			}
		}
	}
	
	//new code : get menu data
	public function getMenuData(){
		$sql = "SELECT * FROM `" . DB_PREFIX . "admin_menu` WHERE parent_id != '0' AND status = '1' ORDER BY name ASC ";
		$data = $this->query($sql);
		return $data->rows;
	}
	
	//add permission
	public function addPermission($user_id,$data){
		$addid = '';
		$editid = '';
		$viewid = '';
		$deletid = '';
		if(isset($data['add']) && !empty($data['add'])){
			$addid = implode(",",$data['add']);
		}
		if(isset($data['edit']) && !empty($data['edit'])){
			$editid = implode(",",$data['edit']);
		}
		if(isset($data['view']) && !empty($data['view'])){
			$viewid = implode(",",$data['view']);
		}
		if(isset($data['delete']) && !empty($data['delete'])){
			$deletid = implode(",",$data['delete']);
		}
		
		$sql = "UPDATE `" . DB_PREFIX . "user` SET add_permission = '" .$addid. "', edit_permission = '" .$editid. "', delete_permission = '" . $deletid . "', view_permission = '" .$viewid. "', date_modify = NOW() WHERE user_id = '" .(int)$user_id. "'";
		$this->query($sql);
	}
	
	public function deleteUser($user_id){
		$sql = "UPDATE `" . DB_PREFIX . "user` SET is_delete=1 WHERE user_id='".$user_id."'";
		$this->query($sql);
	}
	
	public function updateStatus($status,$data){
		if($status == 0 || $status == 1){
			$sql = "UPDATE `" . DB_PREFIX . "user` SET status = '" .(int)$status. "',  date_modify = NOW() WHERE user_id IN (" .implode(",",$data). ")";
			//echo $sql;die;
			$this->query($sql);
		}elseif($status == 2){
			$sql = "UPDATE `" . DB_PREFIX . "user` SET is_delete = '1', date_modify = NOW() WHERE user_id IN (" .implode(",",$data). ")";
			$this->query($sql);
		}
	}
	
	//modified by jayashree
	

	
	
	 public function resetpassword($new_password,$confirm_password,$salt,$account_master_id){
	     
	     	$sql = "UPDATE `" . DB_PREFIX . "account_master` SET salt = '" . $salt . "', password = '" . sha1($salt . sha1($salt . sha1($new_password))) . "' , password_text = '" .$new_password. "', date_modify = NOW() WHERE account_master_id = '".$account_master_id."' ";
   // printr($sql);//die;
        
        	$data=$this->query($sql);
        //	printr('vjvbfwjheb');
        		$sql1 = "DELETE FROM `forgot_password` WHERE `account_master_id`='".$account_master_id."'";
        	//	printr($sql1);//die;
        		$data1=$this->query($sql1);
	        
	     
	 }

}
?>