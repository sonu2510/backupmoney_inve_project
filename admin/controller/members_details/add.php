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
$branch = '';
$branchid = '';

$edit = '';
if(isset($_GET['branch_id']) && !empty($_GET['branch_id'])){
	$branchid=base64_decode($_GET['branch_id']);
	if(!$obj_general->hasPermission('edit',$menuId)){
		$display_status = false;
	}else{
		$branch_id = base64_decode($_GET['branch_id']);
		$branch = $obj_money->getBranch($branch_id);

	
		$edit = 1;
	}
	
}else{
	if(!$obj_general->hasPermission('add',$menuId)){
		$display_status = false;
	}
}

//Close : edit


if($display_status){

//insert
if(isset($_POST['btn_save'])){
	$post = post($_POST);
	//printr($post);die;
	
		$insert_id = $obj_money->addMoney($post);		
		$_SESSION['success'] = ADD;
		page_redirect($obj_general->link($rout, '', '',1));

}
//$branch_id=0;
//edit
$branch_id=0;
if(isset($_POST['btn_update']) && $edit){
	$post = post($_POST);
		$branch_id = $branch['international_branch_id'];	
		$obj_money->updateBranch($branch_id,$post);	
		$_SESSION['success'] = UPDATE;
		page_redirect($obj_general->link($rout, 'filter_edit='.$_GET['filter_edit'], '',1));

}	
?>

<section id="main-content">
  <section class="main padder">
    <div class="row">
      <h4><i class="fa fa-list"></i> Add Money </h4>
    </div>
    <div class="row">
      <div class="col-lg-12">
         <?php include("common/breadcrumb.php");?>  
        </div>   
      <div class="col-sm-12">
          <div class="card">  
        <section class="main-content">

          <div class="card-title">
                <h4><?php echo $display_name;?>  </h4>
                                    
             </div>
         	<br>
         
            <form class="form-horizontal" method="post" name="form" id="form" enctype="multipart/form-data">        
            
            		<div class="form-group has-success">
                         <div class="row">
                                <label class="col-sm-2 control-label">Member Name</label>
                                     <div class="col-sm-6">
                                              <input type="text" name="member_name" value="<?php echo isset($branch['member_name'])?$branch['member_name']:'';?>" class="form-control validate[required]" />
                                    </div>
                         </div>
                  </div>  
            		
                 
				<div class="row">
                <div class="col-md-8 col-md-offset-3">
                	<center>                <?php if($edit){?>
                  	<button type="submit" name="btn_update" id="btn_update" class="btn btn-success btn-rounded m-b-10 m-l-5">Update </button>
                <?php } else { ?>
                	<button type="submit" name="btn_save" id="btn_save" class="btn btn-success btn-rounded m-b-10 m-l-5">Save </button>	
                <?php } ?>  
                  <a class="btn btn-default btn-rounded m-b-10 m-l-5" href="<?php echo $obj_general->link($rout, '', '',1);?>">Cancel</a>
               </center>

                </div>
                </div>
              
               </form>
          </div>
        </section>
        
      </div>
    </div>
  </section>
</section>

<link rel="stylesheet" href="<?php echo HTTP_SERVER;?>js/validation/css/validationEngine.jquery.css" type="text/css"/>
<script src="<?php echo HTTP_SERVER;?>js/validation/languages/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script> 
<script src="<?php echo HTTP_SERVER;?>js/validation/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script> 
<script src="<?php echo HTTP_SERVER;?>ckeditor3/ckeditor.js"></script>
<style type="text/css">
@media (max-width: 400px) {
  .chunk {
    width: 100% !important;
  }
}
</style>
<script>	
    jQuery(document).ready(function(){
		// binds form submission and fields to the validation engine
        jQuery("#form").validationEngine();
		CKEDITOR.replace('email_signature', {
			toolbar: [ 
	{ name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
	{ name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source' ] },
	
	'/',
	{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic','Strike' ] },
	{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote'] },
	
	{ name: 'styles', items: [ 'Styles', 'Format'] },
	]});
	
	CKEDITOR.replace('desc_text');
    });
</script>
<!-- select2 <script src="<?php echo HTTP_SERVER;?>js/select2/select2.min.js"></script>--> 
<script>

    jQuery(document).ready(function(){
        // binds form submission and fields to the validation engine
		//salert($("#default_curr option:selected").text();
        jQuery("#form").validationEngine();
		
		$("#").submit(function (e) {
			//e.preventDefault();
			var name = $("#user_name").val();
			var check = checkUser(name);
			if(!check){
				e.preventDefault();
			}
		});
		
		// UserName Already Exsist Ajax
		$("#user_name").change(function(e){
			var name = $(this).val();
			checkUser(name);
		});
		//alert($('#country_id').val());
		$('#country_id').change(function(){
			var country_id =$('#country_id').val();
			if(country_id == 111 )
			{
				$('#discount_div').show();				
			}
			else
			{
				$('#discount_div').hide();				
			}
		});
		var country_id =$('#country_id').val();
			if(country_id == 111 )
			{
				$('#discount_div').show();				
			}
			else
			{
				$('#discount_div').hide();				
			}
    });
	
	function checkUser(name){
		var orgname = '<?php echo isset($branch['user_name'])?$branch['user_name']:'';?>';
		if(name.length > 0 && orgname != name){
			$(".uniqusername").remove();
			var status_url = getUrl("<?php echo $obj_general->ajaxLink($rout, '&mod=ajax&fun=UserNameAlreadyExsist', '',1);?>");
			$("#loading").show();
			$.ajax({
				url : status_url,
				type :'post',
				data :{name:name},
				success: function(json) {
					if(json > 0){
						$("#user_name").val('');
						$("#user_name").after('<span class="required uniqusername">Username already exists!</span>');
						$("#loading").hide();
						return false;
					}else{
						$("#loading").hide();
						$(".uniqusername").remove();
						return true;
					}
				}
			});
		}else{
			$("#loading").hide();
			$(".uniqusername").remove();
			return true;
		}
	}

//jayashree

function currencyvalue(value)
{
	//alert(this.value);
	//alert($("#default_curr option:selected").text();
	var index = document.getElementById('default_curr').selectedIndex;
	var opt = document.getElementById('default_curr').options;
	var currvalue = opt[index].text;
	//alert(currvalue);
	document.getElementById('currval').value = currvalue;
}
$(".chosen-select").chosen({
		no_results_text: "Oops, nothing found!"
	});
</script> 
<!-- Close : validation script -->

<?php
} else { 
	include_once(DIR_ADMIN.'access_denied.php');
}
?>
