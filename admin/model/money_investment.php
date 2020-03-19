<?php
class money_investment extends dbclass{
	
	public function addMoney($data){		
	
		if(isset($data['member_id']) && !empty($data['member_id'])){
			$member_id=$data['member_id'];
		}else{
				$sql_member = "INSERT INTO " . DB_PREFIX . "members_details SET  member_name = '" . $data['member_name'] . "',status=1, date_added = NOW()";
				$this->query($sql_member);
				$member_id = $this->getLastId();

		}
		$sql = "INSERT INTO " . DB_PREFIX . "add_money SET  member_name = '" . $data['member_name'] . "', member_id = '" . $member_id . "',date='".$data['date']."',amount='".$data['amount']."',remarks='".$data['remarks']."',date_added = '".date('Y-m-d H:i:s')."',date_modify = '".date('Y-m-d H:i:s')."'";
	
		$this->query($sql);
		$money_id = $this->getLastId();
	
		return $money_id;
	}
	
	public function updatemoney($added_money_id,$data){	
	
		
		//printr($data);die;
		
		if(isset($data['member_id']) && !empty($data['member_id'])){
			$member_id=$data['member_id'];
		}else{
				$sql_member = "INSERT INTO " . DB_PREFIX . "members_details SET  member_name = '" . $data['member_name'] . "',status=1, date_added = NOW()";
				$this->query($sql_member);
				$member_id = $this->getLastId();

		}
		//printr($member_id);die;
		$sql = "UPDATE " . DB_PREFIX . "add_money SET  member_id='".$member_id."',member_name = '" . $data['member_name'] . "', date='".$data['date']."',amount='".$data['amount']."',remarks='".$data['remarks']."',date_modify ='".date('Y-m-d H:i:s')."' WHERE added_money_id = '".(int)$added_money_id."'";
		
		$this->query($sql);				
	
		
	}
	
	public function getMoney($added_money_id){
		$sql = "SELECT * FROM " . DB_PREFIX . "add_money WHERE  is_delete=0  AND added_money_id='".$added_money_id."'";
		//echo $sql;die;
		$data = $this->query($sql);
		//printr($data->row);die;
		if($data->num_rows){
			return $data->row;
		}else{
			return false;
		}
	}
	
	public function getTotalAddMoney($filter_array=array()){
		$sql = "SELECT COUNT(*) as total FROM `" . DB_PREFIX ."add_money WHERE  is_delete=0";
		
			
		$data = $this->query($sql);
		return $data->row['total'];
	}
	
	public function getAddMoney(){
		
		$sql = "SELECT * FROM " . DB_PREFIX ."add_money WHERE  is_delete=0";
		
		
		$data = $this->query($sql);
		if($data->num_rows){
			return $data->rows;
		}else{
			return false;
		}
	}
	
	public function member_Details($name){ 
		
		$sql = "SELECT * FROM " . DB_PREFIX ."members_details WHERE  is_delete=0 AND member_name LIKE'%".$name."%'";
		
		//echo $sql;
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
			$sql = "UPDATE `" . DB_PREFIX . "add_money` SET status = '" .(int)$status. "',  date_modify = '".date('Y-m-d H:i:s')."' WHERE added_money_id IN (" .implode(",",$data). ")";
			$this->query($sql);
		
		}elseif($status == 2){
			$sql = "UPDATE `" . DB_PREFIX . "add_money` SET is_delete = '1', date_modify = '".date('Y-m-d H:i:s')."' WHERE added_money_id IN (" .implode(",",$data). ")";
			$this->query($sql);
		
			
		}
	}
	


	
	
}
?>