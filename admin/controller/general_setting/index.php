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
	'text' 	=> $display_name,
	'href' 	=> '',
	'icon' 	=> 'fa-list',
	'class'	=> 'active',
);

if(!$obj_general->hasPermission('view',$menuId)){
	$display_status = false;
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
			$obj_country->updateStatus($status,$_POST['post']);
			$obj_session->data['success'] = UPDATE;
			page_redirect($obj_general->link($rout, '', '',1));
		}
	}else if(isset($_POST['action']) && $_POST['action'] == "delete" && isset($_POST['post']) && !empty($_POST['post'])){
		if(!$obj_general->hasPermission('delete',$menuId)){
			$display_status = false;
		} else {
			//printr($_POST['post']);die;
			$obj_country->updateStatus(2,$_POST['post']);
			$obj_session->data['success'] = UPDATE;
			page_redirect($obj_general->link($rout, '', '',1));
		}
	}

$setting_list = $obj_general_setting->getAllSettings(); 

$setting_data= unserialize($setting_list['setting_details']);
//printr($setting_data);die;
$pagination_data = '';
?>
<section id="main-content">
  <section class="main padder">
    <div class="row">
      <h4><i class="fa fa-list"></i> <?php echo $display_name;?></h4>
    </div>
    <div class="row">
    	<div class="col-lg-12">
	       <?php include("common/breadcrumb.php");?>	
        </div>   
        
      <div class="col-lg-12">
          <div class="card">
        <section class="main-content">
       
          <header class="panel-heading bg-white"> 
		  	       <span><b><?php echo $display_name;?> Listing</b></span>
          	<span class="text-muted m-l-small pull-right">
            	
                <?php
               
				if($obj_general->hasPermission('edit',$menuId)){ ?>
                     	<a class="btn btn-success m-b-10 m-l-5" href="<?php echo $obj_general->link($rout, 'mod=add&setting_id='.$setting_list['general_setting_id'], '',1);?>"><i class="fa fa-plus"></i> Update </a>   
                <?php } ?>

            </span>
          </header>
       
          <form name="form_list" id="form_list" method="post">
           <input type="hidden" id="action" name="action" value="" />
          	
              <div class="table-responsive">
                <table class="table table-hover ">
                  <thead>
                    <tr>      
                      <th>Name</th>
                      <th>Value</th>
                    </tr>
                  </thead>
                  <tbody>
                  	<?php if($setting_list) { ?>
                    	<tr>
                        	<td>Store Name</td>
                    		<td>Admin</td>
                    	</tr>
                        
                        <tr>
                        	<td>Default Email Address</td>
                            <td><?php echo $setting_data['email_address']; ?></td>
                        </tr>
                        
                        <tr>
                        	<td>Items Per Page</td>
                            <td><?php echo $setting_data['items_per_page']; ?></td>
                        </tr>
                        
                      
                        <tr>
                        	<td>System Lock?</td>
                            <td><?php echo ($setting_data['options']==1) ? 'Yes' : 'No'; ?></td>
                        </tr>
                        
                      
                        
                       
                        
                    <?php } else { ?>
                    	<tr>
                        	<td colspan='5'>No record found !</td>
                        </tr>
                    <?php } ?>	
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