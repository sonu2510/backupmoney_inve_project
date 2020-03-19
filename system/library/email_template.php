<?php
class email_template extends dbclass{
		 
	function get_email_template($template_id) {
		$data = $this->query("SELECT * FROM `" . DB_PREFIX . "email_template` WHERE email_template_id = '".(int)$template_id."'");
		if($data->num_rows){
			return $data->row;
		}else{
			return false;
		}
	}
	
	// 1st Template Description , 2nd Tag values , 3rd Template Name  , 4 Subject line 
	function getEmailTemplateContent($message=NULL,$tag=NULL,$subject=NULL, $filename=NULL, $logo_type=NULL, $logo_name=NULL)
	{   
		$f_message = $message;
		if($tag!="")
		{
			foreach($tag as $k=>$v)
			{
				@$f_message = str_replace(trim($k),trim($v),trim($f_message));
			}  
		}

		if($filename == "")
		{
			$filename = "index.html";
		}
		
		$path = "template/".$filename;	
		if (!file_exists($path)) 
		{
			$path = "../template/".$filename;
			if (!file_exists($path)) {
				$path = "../../template/".$filename;
				if(!file_exists($path))
				{
        			return "Error loading template file $path .<br />";
				}
			}
			
	    }  
	    $output = file_get_contents($path);  
		$search  = array('{tag:title}','{tag:details}');
		$replace = array($subject,$f_message);
		$output = str_replace($search, $replace, $output); 
		return $output;
	} 	 	
}

?>