<?php
include("mode_setting.php");

$bradcums = array();
$bradcums[] = array(
	'text' 	=> 'Dashboard',
	'href' 	=> $obj_general->link('dashboard', '', '',1),
	'icon' 	=> 'fa-home',
	'class'	=> '',
);

$bradcums[] = array(
	'text' 	=> $display_name.' List',
	'href' 	=> '',
	'icon' 	=> 'fa-list',
	'class'	=> 'active',
);

if(!$obj_general->hasPermission('view',$menuId)){
	$display_status = false;
}

if(isset($_GET['member_id']) && !empty($_GET['member_id'])){
	$branchid=base64_decode($_GET['member_id']);
	if(!$obj_general->hasPermission('edit',$menuId)){
		$display_status = false;
	}else{
		$member_id = base64_decode($_GET['member_id']);
		$member_data = $obj_money->getMemberData($member_id);

	
		$edit = 1;
	}
	
}else{
	if(!$obj_general->hasPermission('add',$menuId)){
		$display_status = false;
	}
}





if($display_status) {
	
//active inactive delete
if(isset($_POST['action']) && ($_POST['action'] == "active" || $_POST['action'] == "inactive") && isset($_POST['post']) && !empty($_POST['post']))
{
	if(!$obj_general->hasPermission('edit',$menuId)){
		$display_status = false;
	} else {
		$status = 0;
		if($_POST['action'] == "active"){
			$status = 1;
		}
		$obj_money->updateStatus($status,$_POST['post']);
		$obj_session->data['success'] = UPDATE;
		page_redirect($obj_general->link($rout, '', '',1));
	}
}else if(isset($_POST['action']) && $_POST['action'] == "delete" && isset($_POST['post']) && !empty($_POST['post'])){
	if(!$obj_general->hasPermission('delete',$menuId)){
		$display_status = false;
	} else {
		//printr($_POST['post']);die;
		$obj_money->updateStatus(2,$_POST['post']);
		$obj_session->data['success'] = UPDATE;
		page_redirect($obj_general->link($rout, '', '',1));
	}
}	
?>

       

<section id="content">
  <section class="main padder">
    <div class="clearfix">
      <h4><i class="fa fa-list"></i> <?php echo $display_name;?></h4>
    </div>
    <div class="row">
      <div class="col-lg-12">
         <?php include("common/breadcrumb.php");?>  
        </div>   
        
      <div class="col-lg-12">
        <div class="card">
         <div class="card-title">
             <h4><?php echo $display_name;?> Listing </h4>
             <span class="text-muted m-l-small pull-right"> 
               
                     <?php if($obj_general->hasPermission('add',$menuId)){ ?>
                     	<?php if(isset($_SESSION['LOGIN_USER_TYPE']) && $_SESSION['LOGIN_USER_TYPE'] == 1 ) {?>   
                        <a class="btn btn-success btn-outline btn-rounded m-b-10 m-l-5" href="<?php echo $obj_general->link($rout, 'mod=add', '',1);?>"><i class="fa fa-plus"></i> New Member </a>
                    <?php }?>
                    <?php } if($obj_general->hasPermission('delete',$menuId)){ ?>       
                        <a class="btn btn-danger btn-outline btn-rounded m-b-10 m-l-5" onclick="formsubmitsetaction('form_list','delete','post[]','<?php echo DELETE_WARNING;?>')"><i class="fa fa-trash-o"></i> Delete</a>
                    <?php } ?>
             </span>
          </div>
      

          
          <form name="form_list" id="form_list" method="post">   
          <input type="hidden" id="action" name="action" value="" /> 
            <div class="bootstrap-data-table-panel">
               <div class="table-responsive">
              <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
              <thead>
                <tr>
                 <th width="20"><input type="checkbox"></th>

                  <th>Member Name  </th>                  
                  <th>Date</th>               
                  <th>Amount</th>
                  <th>Remark</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              <?php
           
			
				  if($member_data) {
          				  foreach($member_data as $data){           					
          					?>
                               <tr>
                                <td><input type="checkbox" name="post[]" value="<?php echo $data['added_money_id'];?>"></td>
                                <td><?php echo $data['member_name'];?></td>
                                <td><?php echo dateFormat(4,$data['date']);?></td>
                                <td><?php echo $data['amount'];?></td>
                                <td><?php echo $data['remarks'];?></td>                                
                               
                                <td>
                                    <a href="<?php echo $obj_general->link($rout, 'mod=add&added_money_id='.encode($data['added_money_id']).'&filter_edit='.$filter_edit, '',1); ;?>"  name="btn_edit" class="btn btn-info btn-rounded m-b-10 m-l-5">Edit</a>
                                 
                                 </td>
                              </tr>
                <?php
          				  }
    				  }else{
    					  echo "<tr><td colspan='5'>No record found !</td></tr>";	
    				  }
				      	
		
             ?>
                </tbody>
            </table>

            <div class="row">
                <div class="col-md-8 col-md-offset-3">
                  <center>  
                
                  <a class="btn btn-default btn-rounded m-b-10 m-l-5" href="<?php echo $obj_general->link($rout, '', '',1);?>">Cancel</a>
               </center>

                </div>
                </div>
          </div>
          </div>
          </form>
        
        </section>
      </div>
    </div>
  </section>
</section>
   <script src="<?php echo HTTP_SERVER;?>assets/js/lib/data-table/datatables.min.js"></script>   
        <script src="<?php echo HTTP_SERVER;?>assets/js/lib/data-table/dataTables.buttons.min.js"></script>
        <script src="<?php echo HTTP_SERVER;?>assets/js/lib/data-table/buttons.flash.min.js"></script>
        <script src="<?php echo HTTP_SERVER;?>assets/js/lib/data-table/jszip.min.js"></script>
        <script src="<?php echo HTTP_SERVER;?>assets/js/lib/data-table/pdfmake.min.js"></script>
        <script src="<?php echo HTTP_SERVER;?>assets/js/lib/data-table/vfs_fonts.js"></script>
        <script src="<?php echo HTTP_SERVER;?>assets/js/lib/data-table/buttons.html5.min.js"></script>
        <script src="<?php echo HTTP_SERVER;?>assets/js/lib/data-table/buttons.print.min.js"></script>
        <script src="<?php echo HTTP_SERVER;?>assets/js/lib/data-table/datatables-init.js"></script>
<?php } else {
	include(DIR_ADMIN.'access_denied.php');
}
?>


