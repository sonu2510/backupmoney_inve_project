<?php
// Start: Building System
include("mode_setting.php");
$fun = $_GET['fun'];
// End: Building System

if($fun=='member_Details')
{ 
	$data=$obj_money->$fun($_POST['member_name']);
	echo json_encode($data);
}

?>