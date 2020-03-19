<?php
include("mode_setting.php");

//Start : bradcums
$bradcums = array();
$bradcums[] = array(
	'text' 	=> 'Dashboard',
	'href' 	=> $obj_general->link('dashboard', '', '',1),
	'icon' 	=> 'fa-home',
	'class'	=> '',
);

$bradcums[] = array(
	'text' 	=> $display_name.' List',
	'href' 	=> $obj_general->link($rout, '', '',1),
	'icon' 	=> 'fa-list',
	'class'	=> '',
);

$bradcums[] = array(
	'text' 	=> $display_name.' Detail',
	'href' 	=> '',
	'icon' 	=> 'fa-edit',
	'class'	=> 'active',
);
//Close : bradcums

//Start : edit
$edit = '';
$image_path = HTTP_SERVER.'images/blank-user64x64.png';

$admin_login_status = 1;
if(isset($_GET['setting_id']) && !empty($_GET['setting_id'])){
	if(!$obj_general->hasPermission('edit',$menuId)){
		$display_status = false;
	}else{
		$setting_id = base64_decode($_GET['setting_id']);
		$settings = $obj_general_setting->getAllSettings();
		$setting_data= unserialize($settings['setting_details']);
		$edit = 1;
		
		$upload_path = DIR_UPLOAD.'admin/slogo/';
		if(file_exists($upload_path.$setting_data['store_logo'])){
			$image_path = HTTP_UPLOAD.'admin/slogo/'.$setting_data['store_logo'];
		}
		$admin_login_status = $setting_data['options'];
		//echo $setting_data['store_logo'];die;
	//	printr($setting_data);die;
	}
	
}else{
	
	$image_path = '';
	if(!$obj_general->hasPermission('add',$menuId)){
		$display_status = false;
	}
}
//Close : edit

if($display_status){
	//insert user
	if(isset($_POST['btn_save'])){
		$post = post($_POST);
		
		if(isset($_FILES['store_logo']) && !empty($_FILES['store_logo']) && $_FILES['store_logo']['error'] == 0){
			$logo_name = $obj_general_setting->uploadLogoImage($_FILES['store_logo']);
			$post['store_logo'] = $logo_name;	
		}else{	
			$post['store_logo'] = '';
		}
		$serialize_data = serialize($post);
		//print_r($post)."==".print_r($_FILES);die;
		$insert_id = $obj_general_setting->addSetting($serialize_data);
		$obj_session->data['success'] = ADD;
		page_redirect($obj_general->link($rout, '', '',1));
	}
	
	//edit
	if(isset($_POST['btn_update']) && $edit){
		
		
		$post = post($_POST);
		//printr($post);die;
		if(isset($_FILES['store_logo']) && !empty($_FILES['store_logo']) && $_FILES['store_logo']['error'] == 0){
			$logo_name = $obj_general_setting->uploadLogoImage($_FILES['store_logo']);
			$post['store_logo'] = $logo_name;	
		}else{	
			$post['store_logo'] = $setting_data['store_logo'];	
		}
		
		if(!isset($post['options'])) {
			$post['options'] = $admin_login_status;
		}
		$serialize_data = serialize($post);
		//print_r($serialize_data);die;
		$update_id = $obj_general_setting->updateSetting($serialize_data,$_GET['setting_id']);
		$obj_session->data['success'] = ADD;
		page_redirect($obj_general->link($rout, '', '',1));
	}
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
      <div class="col-sm-12">
          <div class="card">  
        <section class="main-content">

          <div class="card-title">
                <h4><?php echo $display_name;?> Detail </h4>
                                    
             </div>
         
         
            <form class="form-horizontal" method="post" name="form" id="form" enctype="multipart/form-data">
            	
                
                
                <section class="main-content">
                 
               
                    <div class="tab-content">
                  
                        <div class="form-group has-success">
                             <div class="row">
                                    <label class="col-sm-3 control-label">Default Email Address</label>
                                         <div class="col-sm-9">
                                                 <input type="text" name="email_address" value="<?php echo isset($setting_data['email_address']) ? $setting_data['email_address'] : ''; ?>" class="form-control validate[required]">
                                         </div>
                               </div>
                           </div> 

                            <div class="form-group has-success">
                             <div class="row">
                                    <label class="col-sm-3 control-label">Default Items Per Page</label>
                                         <div class="col-sm-9">
                                                 <input type="text" name="items_per_page" value="<?php echo isset($setting_data['items_per_page']) ? $setting_data['items_per_page'] : ''; ?>" " class="form-control validate[required]">
                                         </div>
                               </div>
                            </div>

                            <div class="form-group has-success">
                             <div class="row">
                                    <label class="col-sm-3 control-label">System Lock?</label>
                                         <div class="col-sm-9">
                                            <select class="form-control" name="options">
                                                 <option value="1"  <?php echo ($admin_login_status==1) ? 'selected=selected' : '';?>>ON</option>
                                                  <option value="0" <?php echo ($admin_login_status==0) ? 'selected=selected' : '';?>>OFF</option>
                                 
                                                </select>

                                               
                                         </div>
                               </div>
                             </div>

                            <div class="form-group has-success">
                             <div class="row">
                                    <label class="col-sm-3 control-label">Lock Message</label>
                                         <div class="col-sm-9">
                                                <textarea rows="3" cols="10" class="form-control" name="lock_message"><?php echo isset($setting_data['lock_message']) ? $setting_data['lock_message'] : ''; ?></textarea>     
                                         </div>
                               </div>
                            </div>
                      
              			 
                            <div class="form-group has-success">
                             <div class="row">
                                    <label class="col-sm-3 control-label">Backup Period</label>
                                         <div class="col-sm-9">
                                                  
                                       <select class="form-control" name="backup_period">
                                                 <option value="5" selected="selected" <?php echo isset($setting_data['backup_period']) && $setting_data['backup_period']=='5' ? 'selected=selected' : ''; ?> >5days</option>
                                                  <option value="7"  <?php echo isset($setting_data['backup_period']) && $setting_data['backup_period']=='7' ? 'selected=selected' : ''; ?>>7days</option>
                                                  <option value="10" <?php echo isset($setting_data['backup_period']) && $setting_data['backup_period']=='10' ? 'selected=selected' : ''; ?>>10days</option>
                                 
                                        </select>
                                         </div>
                               </div>
                            </div>
                      
                     
                         
                     
                      
                    
                      
              
                    </div>
                
               </section>
  
              <div class="form-group">
                <div class="col-lg-9 col-lg-offset-3">
                <?php if($edit){?>
                  	<button type="submit" name="btn_update" id="btn_update" class="btn btn-success btn-rounded m-b-10 m-l-5">Update </button>
                <?php } else { ?>
                	<button type="submit" name="btn_save" id="btn_save" class="btn btn-success btn-rounded m-b-10 m-l-5">Save </button>	
                <?php } ?>  
                  <a class="btn btn-default btn-rounded m-b-10" href="<?php echo $obj_general->link($rout, '', '',1);?>">Cancel</a>
                </div>
              </div>
            </form>
        
        </section>
          </div>
      </div>
    </div>
  </section>
</section>
<!-- Start : validation script -->
<link rel="stylesheet" href="<?php echo HTTP_SERVER;?>js/validation/css/validationEngine.jquery.css" type="text/css"/>

<script src="<?php echo HTTP_SERVER;?>js/validation/languages/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo HTTP_SERVER;?>js/validation/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>

<script>
    jQuery(document).ready(function(){
        // binds form submission and fields to the validation engine
        jQuery("#form").validationEngine();
    });
</script> 
<!-- Close : validation script -->

<?php } else { 
		include(SERVER_ADMIN_PATH.'access_denied.php');
	}
?>