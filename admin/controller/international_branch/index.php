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


$limit = LISTING_LIMIT;
if(isset($_GET['limit'])){
	$limit = $_GET['limit'];	
}

$filter_data=array();
$filter_value='';

$class='collapse';

if(!isset($_GET['filter_edit'])){
	$filter_edit = 0;
}else{
	$filter_edit = $_GET['filter_edit'];
}

if(!isset($_GET['filter_edit']) || $_GET['filter_edit']==0){
	if(isset($obj_session->data['filter_data'])){
		unset($obj_session->data['filter_data']);	
	}
}


if(isset($obj_session->data['filter_data'])){
	$filter_name = $obj_session->data['filter_data']['name'];
	$filter_email = $obj_session->data['filter_data']['email'];
	$filter_status = $obj_session->data['filter_data']['status'];
	$class = '';
	
	$filter_data=array(
		'name' => $filter_name,
		'email' => $filter_email,
		'status' => $filter_status
	);	
}

if(isset($_POST['btn_filter'])){
	
	$filter_edit = 1;
	$class='';		
	if(isset($_POST['filter_name'])){
		$filter_name=$_POST['filter_name'];		
	}else{
		$filter_name='';
	}
	
	if(isset($_POST['filter_email'])){
		$filter_email=$_POST['filter_email'];
	}else{
		$filter_email='';
	}
	
	if(isset($_POST['filter_status'])){
		$filter_status=$_POST['filter_status'];
	}else{
		$filter_status='';
	}
		
	$filter_data=array(
		'name' => $filter_name,
		'email' => $filter_email,
		'status' => $filter_status
	);
	
	$obj_session->data['filter_data'] = $filter_data;
	
  	
}


if(isset($_GET['order'])){
	$sort_order = $_GET['order'];	
}else{
	$sort_order = 'ASC';	
}


if(isset($_GET['sort'])){
	$sort_name = $_GET['sort'];	
}else{
	$sort_name = 'international_branch_id';
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
		$obj_branch->updateStatus($status,$_POST['post']);
		$obj_session->data['success'] = UPDATE;
		page_redirect($obj_general->link($rout, '', '',1));
	}
}else if(isset($_POST['action']) && $_POST['action'] == "delete" && isset($_POST['post']) && !empty($_POST['post'])){
	if(!$obj_general->hasPermission('delete',$menuId)){
		$display_status = false;
	} else {
		//printr($_POST['post']);die;
		$obj_branch->updateStatus(2,$_POST['post']);
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
                        <a class="btn btn-success btn-outline btn-rounded m-b-10 m-l-5" href="<?php echo $obj_general->link($rout, 'mod=add', '',1);?>"><i class="fa fa-plus"></i> New User </a>
                    <?php } if($obj_general->hasPermission('edit',$menuId)){ ?>
                        <a class="btn btn-success btn-outline btn-rounded m-b-10 m-l-5" style="margin-left:3px;" onclick="formsubmitsetaction('form_list','active','post[]','<?php echo ACTIVE_WARNING;?>')"><i class="fa fa-check"></i> Active</a>
                        <a class="btn btn-warning btn-outline btn-rounded m-b-10 m-l-5" onclick="formsubmitsetaction('form_list','inactive','post[]','<?php echo INACTIVE_WARNING;?>')"><i class="fa fa-times"></i> Inactive</a>
                     <?php } if($obj_general->hasPermission('delete',$menuId)){ ?>       
                        <a class="btn btn-danger btn-outline btn-rounded m-b-10 m-l-5" onclick="formsubmitsetaction('form_list','delete','post[]','<?php echo DELETE_WARNING;?>')"><i class="fa fa-trash-o"></i> Delete</a>
                    <?php } ?>
             </span>
          </div>
          <div class="panel-body">
             

            
 
        </div>

          
          <form name="form_list" id="form_list" method="post">   
          <input type="hidden" id="action" name="action" value="" /> 
            <div class="bootstrap-data-table-panel">
               <div class="table-responsive">
              <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th width="20"><input type="checkbox"></th>

                  <th> Name  </th>
                  
                  <th>Email</th>
               
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              <?php
           
				  $branchs = $obj_branch->getBranchs();
				  if($branchs) {
          				  foreach($branchs as $branch){ 
          					?>
                              <tr>
                                <td><input type="checkbox" name="post[]" value="<?php echo $branch['international_branch_id'];?>"></td>
                                <td><?php echo $branch['name'];?></td>
                                <td><?php echo $branch['email'];?></td>
                                
                                <td><label class="label   
                                  <?php echo ($branch['status']==1)?'btn btn-success btn-rounded m-b-10 m-l-5':'btn btn-warning btn-rounded m-b-10 m-l-5';?>">
                                  <?php echo ($branch['status']==1)?'Active':'Inactive';?>
                                  </label>
                                </td>
                                <td>
                                		<a href="<?php echo $obj_general->link($rout, 'mod=add&branch_id='.encode($branch['international_branch_id']).'&filter_edit='.$filter_edit, '',1); ;?>"  name="btn_edit" class="btn btn-info btn-rounded m-b-10 m-l-5">Edit</a>
                                      <a href="<?php echo $obj_general->link($rout, 'mod=permission&branch_id='.encode($branch['international_branch_id']), '',1);?>"  name="btn_permission" class="btn btn-warning btn-rounded m-b-10 m-l-5">Permission</a>
                                 <!--      <a href="<?php //echo $obj_general->link('employee', 'user_type='.encode(4).'&user_id='.encode($branch['international_branch_id']), '',1);?>"  name="btn_addemployee" class="btn btn-success btn-xs">Employee</a> -->
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
          </div>
          </div>
          </form>
        
        </section>
      </div>
    </div>
  </section>
</section>
<?php } else {
	include(DIR_ADMIN.'access_denied.php');
}
?>


