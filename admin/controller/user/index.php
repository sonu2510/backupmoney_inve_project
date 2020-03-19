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



if(isset($_POST['action']) && $_POST['action'] == "delete" && isset($_POST['post'])){
	foreach($_POST['post'] as $user_id){
		$obj_user->deleteUser($user_id);
	}
}



if($display_status) {
	
	
if(isset($_POST['action']) && ($_POST['action'] == "active" || $_POST['action'] == "inactive") && isset($_POST['post']) && !empty($_POST['post']))
{
	if(!$obj_general->hasPermission('edit',$menuId)){
		$display_status = false;
	} else {
		$status = 0;
		if($_POST['action'] == "active"){
			$status = 1;
		}
		//printr($_POST);die;
		$obj_user->updateStatus($status,$_POST['post']);
		$obj_session->data['success'] = UPDATE;
		page_redirect($obj_general->link($rout, '', '',1));
	}
}else if(isset($_POST['action']) && $_POST['action'] == "delete" && isset($_POST['post']) && !empty($_POST['post'])){
	if(!$obj_general->hasPermission('delete',$menuId)){
		$display_status = false;
	} else {
		//printr($_POST['post']);die;
		$obj_user->updateStatus(2,$_POST['post']);
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
             		<?php if($obj_general->hasPermission('edit',$menuId)){ ?>
   								<a class="btn btn-success m-b-10 m-l-5" href="<?php echo $obj_general->link($rout, 'mod=add', '',1);?>"><i class="fa fa-plus"></i> New User</a>
                      <?php }
							if($obj_general->hasPermission('edit',$menuId)){ ?>
                        		<a class="btn btn-success btn-outline btn-rounded m-b-10 m-l-5" onclick="formsubmitsetaction('form_list','active','post[]','<?php echo ACTIVE_WARNING;?>')"><i class="fa fa-check"></i> Active</a>
                        		<a class="btn btn-warning btn-outline btn-rounded m-b-10 m-l-5" onclick="formsubmitsetaction('form_list','inactive','post[]','<?php echo INACTIVE_WARNING;?>')"><i class="fa fa-times"></i> Inactive</a>
                     <?php }
					 		if($obj_general->hasPermission('delete',$menuId)){ ?>   
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
                  <th>Name</th>
                  <th class="th-sortable <?php echo ($sort_order=='ASC') ? 'active' : ''; ?> ">
                      User Name
                      <span class="th-sort">
                       	<a href="<?php echo $obj_general->link($rout, 'sort=user_name'.'&order=ASC', '',1);?>">
                        <i class="fa fa-sort-down text"></i>
                        <a href="<?php echo $obj_general->link($rout, 'sort=user_name'.'&order=DESC', '',1);?>">
                        <i class="fa fa-sort-up text-active"></i>
                      <i class="fa fa-sort"></i></span>
                  </th>
                  
                  <th class="th-sortable <?php echo ($sort_order=='ASC') ? 'active' : ''; ?> ">
                      Email
                      <span class="th-sort">
                       	<a href="<?php echo $obj_general->link($rout, 'sort=email'.'&order=ASC', '',1);?>">
                        <i class="fa fa-sort-down text"></i>
                        <a href="<?php echo $obj_general->link($rout, 'sort=email'.'&order=DESC', '',1);?>">
                        <i class="fa fa-sort-up text-active"></i>
                      <i class="fa fa-sort"></i></span>
                  </th>
                 
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              <?php
           
			
				  
				  $users = $obj_user->getUsers();
				  if($users) {	
				  foreach($users as $user){ 
					?>
                    <tr>
                      <td><input type="checkbox" name="post[]" value="<?php echo $user['user_id'];?>"></td>
                      <td><?php echo $user['name'];?></td>
                      <td><?php echo $user['user_name'];?></td>
                      <td><?php echo $user['email'];?></td>
                      <td><label class="label   
                        <?php echo ($user['status']==1)?'btn btn-success btn-rounded m-b-10 m-l-5':'btn btn-warning btn-rounded m-b-10 m-l-5';?>">
                        <?php echo ($user['status']==1)?'Active':'Inactive';?>
                        </label>
                      </td>
                      <td>
                      		<a href="<?php echo $obj_general->link($rout, 'mod=add&user_id='.encode($user['user_id']).'&filter_edit=1', '',1);?>"  name="btn_edit" class="btn btn-info btn-rounded m-b-10 m-l-5">Edit</a>
                            <?php if($user['user_id'] != 1){?>
                            <a href="<?php echo $obj_general->link($rout, 'mod=permission&user_id='.encode($user['user_id']), '',1);?>"  name="btn_edit" class="btn btn-warning btn-rounded m-b-10 m-l-5">Permission</a>
                            <?php } ?>
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


