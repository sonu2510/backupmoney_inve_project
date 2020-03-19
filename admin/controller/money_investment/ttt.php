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
//$added_money_id = '';

$edit = '';
if(isset($_GET['added_money_id']) && !empty($_GET['added_money_id'])){
	$added_money_id=base64_decode($_GET['added_money_id']);
	if(!$obj_general->hasPermission('edit',$menuId)){
		$display_status = false;
	}else{
		$added_money_id= base64_decode($_GET['added_money_id']);
		$money = $obj_money->getMoney($added_money_id);

	
		$edit = 1;
	}
	
}else{
	if(!$obj_general->hasPermission('add',$menuId)){
		$display_status = false;
	}
}

//Close : edit

printr($edit);
if($display_status){printr($_POST);//die;
//insert
if(isset($_POST['btn_save'])){
	$post = post($_POST);
	//printr($post);die;
	
		$insert_id = $obj_money->addMoney($post);		
		$_SESSION['success'] = ADD;
		page_redirect($obj_general->link($rout, '', '',1));

}
//$money_id=0;
//edit
$money_id=0;
if(isset($_POST['btn_update']) && $edit){
	$post = post($_POST);
		$money_id = $money['added_money_id'];	
		$obj_money->updatemoney($money_id,$post);	
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
         
            <form class="form-horizontal" method="post" name="form" id="form" action=""enctype="multipart/form-data">        
            
            		<div class="form-group has-success">
                         <div class="row">
                                <label class="col-sm-2 control-label">Member Name</label>
                                     <div class="col-sm-6">
                                              <input type="text" name="member_name" ID="member_name" value="<?php echo isset($money['member_name'])?$money['member_name']:'';?>" class="form-control validate[required]" />
                                                <input type="hidden" name="member_id" id="member_id" value="<?php echo isset($money['member_id'])?$money['member_id']:'';?>" />
                    							<div id="ajax_response"></div>
                                    </div>
                         </div>
                  </div>  
            		<div class="form-group has-success">
                         <div class="row">
                                <label class="col-sm-2 control-label">Date</label>
                                     <div class="col-sm-3">
                                              <input type="date" name="date" id="date-time"  value="<?php if(isset($money['date'])) { echo $money['date']; } else{ echo date("Y-m-d"); }?>" class="form-control validate[required]">
                                    </div>

                                
                          </div>
                 </div> 
                  <div class="form-group has-success">
                         <div class="row">
                              <label class="col-sm-2 control-label">Amount</label>
                                     <div class="col-sm-3">
                                              <input type="text" name="amount" value="<?php echo isset($money['amount'])?$money['amount']:'';?>" class="form-control validate[required,custom[email]]">
                                    </div>   
                          </div>
                  </div>    
                  <div class="form-group has-success">
                         <div class="row">
                              <label class="col-sm-2 control-label">Remarks</label>
                                     <div class="col-sm-3">
                                             <textarea name="remarks" class="form-control "> <?php echo isset($money['remarks'])?$money['remarks']:'';?></textarea>
                                    </div>   
                          </div>
                  </div> 
                 
			  <div class="form-group has-success">
                <div class="col-lg-9 col-lg-offset-3">
                <?php if($edit){?>
                  	<button type="submit" name="btn_update" id="btn_update" class="btn btn-success btn-rounded m-b-10 m-l-5">Update </button>
                <?php } else { ?>
                	<button type="submit" name="btn_save" id="btn_save" class="btn btn-success btn-rounded m-b-10 m-l-5">Save </button>	
                <?php } ?>  
                  <a class="btn btn-default btn-rounded m-b-10 m-l-5" href="<?php echo $obj_general->link($rout, '', '',1);?>">Cancel</a>
                </div>
              </div>
              
               </form>
          </div>
        </section>
        
      </div>
    </div>
  </section>
</section>
<style type="text/css">
#ajax_response, #ajax_res,#ajax_return{
	border : 1px solid #13c4a5;
	background : #FFFFFF;
	position:relative;
	display:none;
	padding:2px 2px;
	top:auto;
	border-radius: 4px;
}
#holder{
	width : 350px;
}
.list {
	padding:0px 0px;
	margin:0px;
	list-style : none;
}
.list li a{
	text-align : left;
	padding:2px;
	cursor:pointer;
	display:block;
	text-decoration : none;
	color:#000000;
}

</style>

  

<link rel="stylesheet" href="<?php echo HTTP_SERVER;?>assets/js/validation/css/validationEngine.jquery.css" type="text/css"/>
<script src="<?php echo HTTP_SERVER;?>assets/js/validation/languages/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script> 
<script src="<?php echo HTTP_SERVER;?>assets/js/validation/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script> 

<script type="text/javascript">
	jQuery(document).ready(function(){


$("#member_name").focus();

	var offset = $("#product_item_id").offset();
	
	var width = $("#holder").width();
	
	$("#ajax_response").css("width",width);

	//alert('qwufguifguyfg');	
	$("#member_name").keyup(function(event){	
	
		 var keyword = $("#member_name").val();
		
		 if(keyword.length)
		 {	
			 if(event.keyCode != 40 && event.keyCode != 38 )
			 {
				 var product_url = getUrl("<?php echo $obj_general->ajaxLink($rout, 'mod=ajax&fun=member_Details', '',1);?>");
				 $("#loading").css("visibility","visible");
				 $.ajax({
				   type: "POST",
				   url: product_url,
				   data: "member_name="+keyword,
				   success: function(msg){	
					 var msg = $.parseJSON(msg);
				   var div='<ul class="list">';
				   
					if(msg.length>0)
					{ 	
						for(var i=0;i<msg.length;i++)
						{	
							div =div+'<li><a href=\'javascript:void(0);\' member_name ="'+msg[i].member_name+'" member_id="'+msg[i].member_id+'"  ><span class="bold" >'+msg[i].member_name+'</span></a></li>';
						}
					}
					
					div=div+'</ul>';
				
					if(msg != 0)
					  $("#ajax_response").fadeIn("slow").html(div);
					else
					{
						$("#ajax_response").fadeIn("slow");	
						$("#ajax_response").html('<div style="text-align:left;">No Matches Found</div>');
				  		$("#member_id").val('');
				  	
					}
					$("#loading").css("visibility","hidden");
				   }
				 });
			 }
			 else
			 {				
				switch (event.keyCode)
				{
				 case 40:
				 {
					  found = 0;
					  $(".list li").each(function(){
						 if($(this).attr("class") == "selected")
							found = 1;
					  });
					  if(found == 1)
					  {
						var sel = $(".list li[class='selected']");
						sel.next().addClass("selected");
						sel.removeClass("selected");										
					  }
					  else
						$(".list li:first").addClass("selected");
						if($(".list li[class='selected'] a").text()!='')
						{
							$("#member_name").val($(".list li[class='selected'] a").text());
							$("#member_id").val($(".list li[class='selected'] a").attr("id"));
							
						}
				}
				 break;
				 case 38:
				 {
					  found = 0;
					  $(".list li").each(function(){
						 if($(this).attr("class") == "selected")
							found = 1;
					  });
					  if(found == 1)
					  {
						var sel = $(".list li[class='selected']");
						sel.prev().addClass("selected");
						sel.removeClass("selected");
					  }
					  else
						$(".list li:last").addClass("selected");
						if($(".list li[class='selected'] a").text()!='')
						{
							$("#member_name").val($(".list li[class='selected'] a").text());
							$("#member_id").val($(".list li[class='selected'] a").attr("id"));
							
						}
				 }
				 break;				 
				}
			 }
		 }
		 else
		 {
			$("#ajax_response").fadeOut('slow');
			$("#ajax_response").html("");
		 }
	});
	
	$('#member_name').keydown( function(e) {
		if (e.keyCode == 9) {
			 $("#ajax_response").fadeOut('slow');
			 $("#ajax_response").html("");
		}
	});

	$("#ajax_response").mouseover(function(){
				$(this).find(".list li a:first-child").mouseover(function () {
					  $("#member_id").val($(this).attr("id"));
					
					  $(this).addClass("selected");
				});
				$(this).find(".list li a:first-child").mouseout(function () {
					  $(this).removeClass("selected");
					  $("#member_id").val('');
					
				});
				$(this).find(".list li a:first-child").click(function () {
					  $("#member_id").val($(this).attr("id"));
					  
					  
					  $("#member_name").val($(this).text());
					 $("#ajax_response").fadeOut('slow');
					  $("#ajax_response").html("");
					  
					
				});
				
			});
    });
	


</script> 
<!-- Close : validation script -->

<?php
} else { 
	include_once(DIR_ADMIN.'access_denied.php');
}
?>
