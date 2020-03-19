<?php
class money_investment extends dbclass{
	
	public function addMoney($data){		
	

		$sql_member = "INSERT INTO " . DB_PREFIX . "members_details SET  member_name = '" . $data['member_name'] . "',status=1, date_added = NOW()";
		$this->query($sql_member);
		$member_id = $this->getLastId();


		
	
	
		return $member_id;
	}
	
	public function updateMoney($member_id,$data){	
	
		
		
	
		$sql = "UPDATE `" . DB_PREFIX . "members_details SET  member_name = '" . $data['member_name'] . "',date_modify ='".date('Y-m-d H:i:s')."' WHERE member_id = '".(int)$member_id."'";
		//echo $sql;die;
		$this->query($sql);				
	
		
	}
	
	public function getMemberData($member_id){
			
		
		$sql = "SELECT * FROM " . DB_PREFIX ."add_money WHERE  is_delete=0 AND member_id='".$member_id."'";
		
		
		$data = $this->query($sql);
		if($data->num_rows){
			return $data->rows;
		}else{
			return false;
		}

	}
	
	public function getTotalAddMoney($filter_array=array()){
		$sql = "SELECT COUNT(*) as total FROM `" . DB_PREFIX ."members_details WHERE  is_delete=0";
		
			
		$data = $this->query($sql);
		return $data->row['total'];
	}
	
	public function getMembers(){
		
		$sql = "SELECT *, SUM(a.amount) as total_amount FROM " . DB_PREFIX ."members_details as m,add_money as a WHERE  a.member_id=m.member_id AND a.is_delete=0 GROUP BY m.member_id";
		
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
			$sql = "UPDATE `" . DB_PREFIX . "members_details` SET status = '" .(int)$status. "',  date_modify = '".date('Y-m-d H:i:s')."' WHERE member_id IN (" .implode(",",$data). ")";
			$this->query($sql);
		
		}elseif($status == 2){
			$sql = "UPDATE `" . DB_PREFIX . "members_details` SET is_delete = '1', date_modify = '".date('Y-m-d H:i:s')."' WHERE member_id IN (" .implode(",",$data). ")";
			$this->query($sql);
		
			
		}
	}
	


	
	
}
?>