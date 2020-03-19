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
$mod='';
if(isset($_GET['p']))
	$mod ='&mod=person';
$bradcums[] = array(
	'text' 	=> $display_name.' List',
	'href' 	=> $obj_general->link($rout, $mod, '',1),
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

$limit = LISTING_LIMIT;
if(isset($_GET['limit'])){
	$limit = $_GET['limit'];	
}

$user_type_id = $_SESSION['LOGIN_USER_TYPE'];
$user_id = $_SESSION['ADMIN_LOGIN_SWISS'];

//Start : edit
$edit = '';
//Close : edit
if($display_status){
    $get_user=$obj_invoice->getUser($_SESSION['ADMIN_LOGIN_SWISS'],$_SESSION['LOGIN_USER_TYPE']);

    if($_SESSION['ADMIN_LOGIN_SWISS']=='1' && $_SESSION['LOGIN_USER_TYPE']=='1')
	    $get_user['user_id']='';
   
    $rout_sales = 'sales_invoice';
    $sales_id = $obj_general->getMenuId($rout_sales);
    
    $rout_gove = 'government_sales_invoice';
    $gov_id = $obj_general->getMenuId($rout_gove);
    
    $proforma_pro_wise_id = $obj_general->getMenuId('proforma_invoice_product_code_wise');
?>

<section id="content">
  <section class="main padder">
    <div class="clearfix">
      <h4><i class="fa fa-edit"></i></h4>
    </div>
    <div class="row">
    	<div class="col-lg-12">
	       <?php include("common/breadcrumb.php");?>	
        </div> 
        <div class="col-sm-12">
            <section class="panel"> 
                <header class="panel-heading bg-white">
                    <span>Chart</span>             
                </header>
                <div class="panel-body">
              	    <script src="<?php echo HTTP_SERVER;?>js/Chart.bundle.js"></script>
					<section class="panel">
						<div class="carousel slide auto panel-body" id="c-slide">
						
    						<div class="carousel-inner">
								<div class="item active">
									 <?php 	if($obj_general->hasPermission('add',$sales_id ) || $obj_general->hasPermission('add',$gov_id ))
										{?>
											<div class="row">
											   <div class="col-md-12">
											   <?php $sales = $obj_dashboard->GetTotalSales('');?>
														<input type="hidden" id="arr" value="<?php echo json_encode($sales);?>">	
														<div style="font-size:16px;"><b>SALES CHART <?php echo date("Y");?></b></div>
														<canvas id="myChart" height="50"></canvas>					
												</div>
											   </div>
												<script>
													var ctx = document.getElementById("myChart").getContext('2d');
													var myChart = new Chart(ctx, {
														type: 'bar',
														data: {
															labels: ["Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sept", "Oct", "Nov", "Dec"],
															datasets: [
															<?php 
																		if(isset($sales) && !empty($sales))
																		{ 
																			foreach($sales as $key =>$s)
																			{
																				if($_SESSION['ADMIN_LOGIN_SWISS']=='1' && $_SESSION['LOGIN_USER_TYPE']=='1')
																				{
																					echo $view=$obj_dashboard->getChartView($s,'','',$key);
																				}
																				else
																				{											
																					foreach($s as $month)
																					{ 
																						$country = 'rgba('.rand(0,255).','.rand(0,255).','.rand(0,255).','.rand(0,255).')';
																						$con_curr = $month['user_name'];
																						$arr[$month['user_name']][]=array(
																								  'con_curr'=>$con_curr,
																								  'Final_Total'=>$month['Final_Total'],
																								  'month'=>$month['month'],
																								  'user_name'=>$month['user_name']);
																					}
																					foreach($arr as $key1=>$sal)
																					{ $Jan=$Feb=$Mar=$Apr=$May=$June=$July=$Aug=$Sept=$Oct=$Nov=$Dec="0";
																						foreach($sal as $month)
																						{ 	if(strtoupper($month['month'])==strtoupper('January'))
																							{
																								$Jan=$month['Final_Total'];
																							}
																							elseif(strtoupper($month['month'])==strtoupper('February'))
																							{
																								$Feb=$month['Final_Total'];
																							}
																							elseif(strtoupper($month['month'])==strtoupper('March'))
																							{
																								$Mar=$month['Final_Total'];
																							}
																							elseif(strtoupper($month['month'])==strtoupper('April'))
																							{
																								$Apr=$month['Final_Total'];
																							}
																							elseif(strtoupper($month['month'])==strtoupper('May'))
																							{
																								$May=$month['Final_Total'];
																							}
																							elseif(strtoupper($month['month'])==strtoupper('June'))
																							{
																								$June=$month['Final_Total'];
																							}
																							elseif(strtoupper($month['month'])==strtoupper('July'))
																							{
																								$July=$month['Final_Total'];
																							}
																							elseif(strtoupper($month['month'])==strtoupper('August'))
																							{
																								$Aug=$month['Final_Total'];
																							}
																							elseif(strtoupper($month['month'])==strtoupper('September'))
																							{
																								$Sept=$month['Final_Total'];
																							}
																							elseif(strtoupper($month['month'])==strtoupper('October'))
																							{
																								$Oct=$month['Final_Total'];
																							}
																							elseif(strtoupper($month['month'])==strtoupper('November'))
																							{
																								$Nov=$month['Final_Total'];
																							}
																							else
																							{	
																								$Dec=$month['Final_Total'];
																							}
					
																																			
																						}
																						$color='rgba('.rand(0,255).','.rand(0,255).','.rand(0,255).','.rand(0,255).')';
																							echo  "{
																										label: '".$key1."',
																										data: [".$Jan.",".$Feb.",".$Mar.",".$Apr.",".$May.",".$June.",".$July.",".$Aug.",".$Sept.",".$Oct.",".$Nov.",".$Dec."],
																										backgroundColor: ['".$color."','".$color."','".$color."','".$color."','".$color."','".$color."','".$color."','".$color."','".$color."','".$color."','".$color."','".$color."'],
																										borderColor: [
																												'rgba(255,99,132,1)',
																												'rgba(255,99,132,1)',
																												'rgba(255,99,132,1)',
																												'rgba(255,99,132,1)',
																												'rgba(255,99,132,1)',
																												'rgba(255,99,132,1)',
																												'rgba(255,99,132,1)',
																												'rgba(255,99,132,1)',
																												'rgba(255,99,132,1)',
																												'rgba(255,99,132,1)',
																												'rgba(255,99,132,1)',
																												'rgba(255,99,132,1)',
																												],
																														borderWidth: 1
																														},	";
																					}
																				}	
																					
																				
																					
																			}
																		}
																	?>
																	]
														},
														options: {
															scales: {
																yAxes: [{
																	ticks: {
																		beginAtZero:true
																	}
																}]
															}
														}
													});
										</script>
									        </div>
        					</div>	<?php
        								     if(isset($get_user['international_branch_id']) &&  $get_user['international_branch_id']=='10')
											{?>
												<div class="carousel-inner g">
												    <div class="item active">
														<div class="row">
														   <div class="col-md-12">
														   <?php $sales1 = $obj_dashboard->GetTotalSales('USD'); ?>
																	<input type="hidden" id="arr1" value="<?php echo json_encode($sales);?>">	
																	<div style="font-size:16px;"><b>SALES CHART (USD) <?php echo date("Y");?></b></div>
																	<canvas id="myChartsale" height="50"></canvas>					
															</div>
														

														   </div>
															<script>
																var ctx = document.getElementById("myChartsale").getContext('2d');
																var myChartsale = new Chart(ctx, {
																	type: 'bar',
																
																	data: {
																		labels: ["Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sept", "Oct", "Nov", "Dec"],
																		
																		datasets: [
																		<?php 
																					if(isset($sales1) && !empty($sales1))
																					{ 
																						foreach($sales1 as $key =>$s1)
																						{
																						
																								foreach($s1 as $month)
																								{ 
																									$country = 'rgba('.rand(0,255).','.rand(0,255).','.rand(0,255).','.rand(0,255).')';
																									$con_curr = $month['user_name'];
																									$arr1[$month['user_name']][]=array(//'country'=>$country,
																											  'con_curr'=>$con_curr,
																											  'Final_Total'=>$month['Final_Total'],
																											  'month'=>$month['month'],
																											  'user_name'=>$month['user_name']);
																								}
																							
																								foreach($arr1 as $key1=>$sal1)
																								{ $Jan=$Feb=$Mar=$Apr=$May=$June=$July=$Aug=$Sept=$Oct=$Nov=$Dec="0";
																									foreach($sal1 as $month)
																									{ 	if(strtoupper($month['month'])==strtoupper('January'))
																										{
																											$Jan=$month['Final_Total'];
																										}
																										elseif(strtoupper($month['month'])==strtoupper('February'))
																										{
																											$Feb=$month['Final_Total'];
																										}
																										elseif(strtoupper($month['month'])==strtoupper('March'))
																										{
																											$Mar=$month['Final_Total'];
																										}
																										elseif(strtoupper($month['month'])==strtoupper('April'))
																										{
																											$Apr=$month['Final_Total'];
																										}
																										elseif(strtoupper($month['month'])==strtoupper('May'))
																										{
																											$May=$month['Final_Total'];
																										}
																										elseif(strtoupper($month['month'])==strtoupper('June'))
																										{
																											$June=$month['Final_Total'];
																										}
																										elseif(strtoupper($month['month'])==strtoupper('July'))
																										{
																											$July=$month['Final_Total'];
																										}
																										elseif(strtoupper($month['month'])==strtoupper('August'))
																										{
																											$Aug=$month['Final_Total'];
																										}
																										elseif(strtoupper($month['month'])==strtoupper('September'))
																										{
																											$Sept=$month['Final_Total'];
																										}
																										elseif(strtoupper($month['month'])==strtoupper('October'))
																										{
																											$Oct=$month['Final_Total'];
																										}
																										elseif(strtoupper($month['month'])==strtoupper('November'))
																										{
																											$Nov=$month['Final_Total'];
																										}
																										else
																										{	
																											$Dec=$month['Final_Total'];
																										}
                                                                                                    }
																									$color='rgba('.rand(0,255).','.rand(0,255).','.rand(0,255).','.rand(0,255).')';
																										echo  "{
																													label: '".$key1."',
																													data: [".$Jan.",".$Feb.",".$Mar.",".$Apr.",".$May.",".$June.",".$July.",".$Aug.",".$Sept.",".$Oct.",".$Nov.",".$Dec."],
																													backgroundColor: ['".$color."','".$color."','".$color."','".$color."','".$color."','".$color."','".$color."','".$color."','".$color."','".$color."','".$color."','".$color."'],
																													borderColor: [
																															'rgba(255,99,132,1)',
																															'rgba(255,99,132,1)',
																															'rgba(255,99,132,1)',
																															'rgba(255,99,132,1)',
																															'rgba(255,99,132,1)',
																															'rgba(255,99,132,1)',
																															'rgba(255,99,132,1)',
																															'rgba(255,99,132,1)',
																															'rgba(255,99,132,1)',
																															'rgba(255,99,132,1)',
																															'rgba(255,99,132,1)',
																															'rgba(255,99,132,1)',
																															],
																																	borderWidth: 1
																																	},	";
																								}
																								
																								
																							
																								
																						}
																					}
																				?>
																				]
																	},
																	options: {
																		scales: {
																			yAxes: [{
																				ticks: {
																					beginAtZero:true
																				}
																			}]
																		}
																	}
																});
													</script>
												</div>
											    </div>
												<div class="carousel-inner">
												    <div class="item active">
														<div class="row">
														   <div class="col-md-12">
														   <?php    $sales_pre = $obj_dashboard->GetTotalSales('USD',date("Y",strtotime("-1 year"))); ?>
																	<input type="hidden" id="arr_pre" value="<?php echo json_encode($sales_pre);?>">	
																	<div style="font-size:16px;"><b>SALES CHART (USD) <?php echo date("Y",strtotime("-1 year"));?></b></div>
																	<canvas id="myChartsale_pre" height="50"></canvas>					
															</div>
														

														   </div>
															<script>
																var ctx = document.getElementById("myChartsale_pre").getContext('2d');
																var myChartsale_pre = new Chart(ctx, {
																	type: 'bar',
																	
																	data: {
																		labels: ["Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sept", "Oct", "Nov", "Dec"],
																		
																		datasets: [
																		<?php 
																					if(isset($sales_pre) && !empty($sales_pre))
																					{ 
																						foreach($sales_pre as $key =>$s1)
																						{
																						
																								foreach($s1 as $month)
																								{
																									$country = 'rgba('.rand(0,255).','.rand(0,255).','.rand(0,255).','.rand(0,255).')';
																									$con_curr = $month['user_name'];
																									$arr1[$month['user_name']][]=array(//'country'=>$country,
																											  'con_curr'=>$con_curr,
																											  'Final_Total'=>$month['Final_Total'],
																											  'month'=>$month['month'],
																											  'user_name'=>$month['user_name']);
																								}
																						
																								foreach($arr1 as $key1=>$sal1)
																								{ $Jan=$Feb=$Mar=$Apr=$May=$June=$July=$Aug=$Sept=$Oct=$Nov=$Dec="0";
																									foreach($sal1 as $month)
																									{ 	if(strtoupper($month['month'])==strtoupper('January'))
																										{
																											$Jan=$month['Final_Total'];
																										}
																										elseif(strtoupper($month['month'])==strtoupper('February'))
																										{
																											$Feb=$month['Final_Total'];
																										}
																										elseif(strtoupper($month['month'])==strtoupper('March'))
																										{
																											$Mar=$month['Final_Total'];
																										}
																										elseif(strtoupper($month['month'])==strtoupper('April'))
																										{
																											$Apr=$month['Final_Total'];
																										}
																										elseif(strtoupper($month['month'])==strtoupper('May'))
																										{
																											$May=$month['Final_Total'];
																										}
																										elseif(strtoupper($month['month'])==strtoupper('June'))
																										{
																											$June=$month['Final_Total'];
																										}
																										elseif(strtoupper($month['month'])==strtoupper('July'))
																										{
																											$July=$month['Final_Total'];
																										}
																										elseif(strtoupper($month['month'])==strtoupper('August'))
																										{
																											$Aug=$month['Final_Total'];
																										}
																										elseif(strtoupper($month['month'])==strtoupper('September'))
																										{
																											$Sept=$month['Final_Total'];
																										}
																										elseif(strtoupper($month['month'])==strtoupper('October'))
																										{
																											$Oct=$month['Final_Total'];
																										}
																										elseif(strtoupper($month['month'])==strtoupper('November'))
																										{
																											$Nov=$month['Final_Total'];
																										}
																										else
																										{	
																											$Dec=$month['Final_Total'];
																										}
                                                                                                    }
																									$color='rgba('.rand(0,255).','.rand(0,255).','.rand(0,255).','.rand(0,255).')';
																										echo  "{
																													label: '".$key1."',
																													data: [".$Jan.",".$Feb.",".$Mar.",".$Apr.",".$May.",".$June.",".$July.",".$Aug.",".$Sept.",".$Oct.",".$Nov.",".$Dec."],
																													backgroundColor: ['".$color."','".$color."','".$color."','".$color."','".$color."','".$color."','".$color."','".$color."','".$color."','".$color."','".$color."','".$color."'],
																													borderColor: [
																															'rgba(255,99,132,1)',
																															'rgba(255,99,132,1)',
																															'rgba(255,99,132,1)',
																															'rgba(255,99,132,1)',
																															'rgba(255,99,132,1)',
																															'rgba(255,99,132,1)',
																															'rgba(255,99,132,1)',
																															'rgba(255,99,132,1)',
																															'rgba(255,99,132,1)',
																															'rgba(255,99,132,1)',
																															'rgba(255,99,132,1)',
																															'rgba(255,99,132,1)',
																															],
																																	borderWidth: 1
																																	},	";
																								}
																								
																								
																							
																								
																						}
																					}
																				?>
																				]
																	},
																	options: {
																		scales: {
																			yAxes: [{
																				ticks: {
																					beginAtZero:true
																				}
																			}]
																		}
																	}
																});
													</script>
												</div>
											    </div>
											    <div class="carousel-inner">
												    <div class="item active">
    												<div class="row">
    													   <div class="col-md-12">
    													   <?php $sales_pre1 = $obj_dashboard->GetTotalSales('',date("Y",strtotime("-1 year")));?>
    																<input type="hidden" id="arr_pre1" value="<?php echo json_encode($sales_pre1);?>">	
    																<div style="font-size:16px;"><b>SALES CHART (MXN) <?php echo date("Y",strtotime("-1 year"));?></b></div>
    																<canvas id="myChart_pre1" height="50"></canvas>					
    														</div>
    													   </div>
    													 <script>
    															var ctx = document.getElementById("myChart_pre1").getContext('2d');
    															var myChart_pre1 = new Chart(ctx, {
    																type: 'bar',
    																data: {
    																	labels: ["Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sept", "Oct", "Nov", "Dec"],
    																	datasets: [
    																	<?php 
    																				if(isset($sales_pre1) && !empty($sales_pre1))
    																				{ 
    																					foreach($sales_pre1 as $key =>$s)
    																					{
    																						if($_SESSION['ADMIN_LOGIN_SWISS']=='1' && $_SESSION['LOGIN_USER_TYPE']=='1')
    																						{
    																						    echo $view=$obj_dashboard->getChartView($s,'','',$key);
    																						}
    																						else
    																						{											
    																							foreach($s as $month)
    																							{
    																								$country = 'rgba('.rand(0,255).','.rand(0,255).','.rand(0,255).','.rand(0,255).')';
    																								$con_curr = $month['user_name'];
    																								$arr[$month['user_name']][]=array(
    																										  'con_curr'=>$con_curr,
    																										  'Final_Total'=>$month['Final_Total'],
    																										  'month'=>$month['month'],
    																										  'user_name'=>$month['user_name']);
    																							}
    																							foreach($arr as $key1=>$sal)
    																							{ $Jan=$Feb=$Mar=$Apr=$May=$June=$July=$Aug=$Sept=$Oct=$Nov=$Dec="0";
    																								foreach($sal as $month)
    																								{ 	if(strtoupper($month['month'])==strtoupper('January'))
    																									{
    																										$Jan=$month['Final_Total'];
    																									}
    																									elseif(strtoupper($month['month'])==strtoupper('February'))
    																									{
    																										$Feb=$month['Final_Total'];
    																									}
    																									elseif(strtoupper($month['month'])==strtoupper('March'))
    																									{
    																										$Mar=$month['Final_Total'];
    																									}
    																									elseif(strtoupper($month['month'])==strtoupper('April'))
    																									{
    																										$Apr=$month['Final_Total'];
    																									}
    																									elseif(strtoupper($month['month'])==strtoupper('May'))
    																									{
    																										$May=$month['Final_Total'];
    																									}
    																									elseif(strtoupper($month['month'])==strtoupper('June'))
    																									{
    																										$June=$month['Final_Total'];
    																									}
    																									elseif(strtoupper($month['month'])==strtoupper('July'))
    																									{
    																										$July=$month['Final_Total'];
    																									}
    																									elseif(strtoupper($month['month'])==strtoupper('August'))
    																									{
    																										$Aug=$month['Final_Total'];
    																									}
    																									elseif(strtoupper($month['month'])==strtoupper('September'))
    																									{
    																										$Sept=$month['Final_Total'];
    																									}
    																									elseif(strtoupper($month['month'])==strtoupper('October'))
    																									{
    																										$Oct=$month['Final_Total'];
    																									}
    																									elseif(strtoupper($month['month'])==strtoupper('November'))
    																									{
    																										$Nov=$month['Final_Total'];
    																									}
    																									else
    																									{	
    																										$Dec=$month['Final_Total'];
    																									}
    							
    																																					
    																								}
    																								$color='rgba('.rand(0,255).','.rand(0,255).','.rand(0,255).','.rand(0,255).')';
    																									echo  "{
    																												label: '".$key1."',
    																												data: [".$Jan.",".$Feb.",".$Mar.",".$Apr.",".$May.",".$June.",".$July.",".$Aug.",".$Sept.",".$Oct.",".$Nov.",".$Dec."],
    																												backgroundColor: ['".$color."','".$color."','".$color."','".$color."','".$color."','".$color."','".$color."','".$color."','".$color."','".$color."','".$color."','".$color."'],
    																												borderColor: [
    																														'rgba(255,99,132,1)',
    																														'rgba(255,99,132,1)',
    																														'rgba(255,99,132,1)',
    																														'rgba(255,99,132,1)',
    																														'rgba(255,99,132,1)',
    																														'rgba(255,99,132,1)',
    																														'rgba(255,99,132,1)',
    																														'rgba(255,99,132,1)',
    																														'rgba(255,99,132,1)',
    																														'rgba(255,99,132,1)',
    																														'rgba(255,99,132,1)',
    																														'rgba(255,99,132,1)',
    																														],
    																																borderWidth: 1
    																																},	";
    																							}
    																						}	
    																							
    																						
    																							
    																					}
    																				}
    																			?>
    																			]
    																},
    																options: {
    																	scales: {
    																		yAxes: [{
    																			ticks: {
    																				beginAtZero:true
    																			}
    																		}]
    																	}
    																}
    															});
    												</script>
    											
    										        </div>
    									        </div>
    									<?php }
        								 }
        								 if(($_SESSION['ADMIN_LOGIN_SWISS']=='1' && $_SESSION['LOGIN_USER_TYPE']=='1') OR (isset($get_user['international_branch_id']) &&  $get_user['international_branch_id']!='10'))
										 {
													if($obj_general->hasPermission('add',$proforma_pro_wise_id ))
													{ ?>
														<div class="carousel-inner">
														    <div class="item active">
															<div class="row">
																 <div class="col-md-12">
																   <?php $proformadataProductCodeWise = $obj_dashboard->GetTotalProformaProductCodeWise();//printr($proformadata);?>
																			<input type="hidden" id="arr" value="<?php echo json_encode($proformadataProductCodeWise);?>">	
																			<div style="font-size:16px;"><b>PROFORMA CHART <?php echo date("Y");?></b></div>
																			<canvas id="myChartProCode" height="50"></canvas>
																	</div>
																

																   </div>
																   <script>
																	var ctx = document.getElementById("myChartProCode").getContext('2d');
																	var myChart = new Chart(ctx, {
																		type: 'bar',
																		data: {
																			labels: ["Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sept", "Oct", "Nov", "Dec"],
																			datasets: [
																			<?php 
																						if(isset($proformadataProductCodeWise))
																						{ 
																							foreach($proformadataProductCodeWise as $key =>$s)
																							{
																								if($_SESSION['ADMIN_LOGIN_SWISS']=='1' && $_SESSION['LOGIN_USER_TYPE']=='1')
																								{
																									echo $view=$obj_dashboard->getChartView($s,'','',$key);
																								}
																								else
																								{											
																									foreach($s as $month)
																									{
																										$country = 'rgba('.rand(0,255).','.rand(0,255).','.rand(0,255).','.rand(0,255).')';
																										$con_curr = $month['user_name'];
																										$arr[$month['user_name']][]=array(
																												  'con_curr'=>$con_curr,
																												  'Final_Total'=>$month['Final_Total'],
																												  'month'=>$month['month'],
																												  'user_name'=>$month['user_name']);
																									}
																									
																									foreach($arr as $key=>$sal)
																									{ $Jan=$Feb=$Mar=$Apr=$May=$June=$July=$Aug=$Sept=$Oct=$Nov=$Dec="0";
																										foreach($sal as $month)
																										{ 	if(strtoupper($month['month'])==strtoupper('January'))
																											{
																												$Jan=$month['Final_Total'];
																											}
																											elseif(strtoupper($month['month'])==strtoupper('February'))
																											{
																												$Feb=$month['Final_Total'];
																											}
																											elseif(strtoupper($month['month'])==strtoupper('March'))
																											{
																												$Mar=$month['Final_Total'];
																											}
																											elseif(strtoupper($month['month'])==strtoupper('April'))
																											{
																												$Apr=$month['Final_Total'];
																											}
																											elseif(strtoupper($month['month'])==strtoupper('May'))
																											{
																												$May=$month['Final_Total'];
																											}
																											elseif(strtoupper($month['month'])==strtoupper('June'))
																											{
																												$June=$month['Final_Total'];
																											}
																											elseif(strtoupper($month['month'])==strtoupper('July'))
																											{
																												$July=$month['Final_Total'];
																											}
																											elseif(strtoupper($month['month'])==strtoupper('August'))
																											{
																												$Aug=$month['Final_Total'];
																											}
																											elseif(strtoupper($month['month'])==strtoupper('September'))
																											{
																												$Sept=$month['Final_Total'];
																											}
																											elseif(strtoupper($month['month'])==strtoupper('October'))
																											{
																												$Oct=$month['Final_Total'];
																											}
																											elseif(strtoupper($month['month'])==strtoupper('November'))
																											{
																												$Nov=$month['Final_Total'];
																											}
																											else
																											{	
																												$Dec=$month['Final_Total'];
																											}

																																							
																										}
																										
																										$color='rgba('.rand(0,255).','.rand(0,255).','.rand(0,255).','.rand(0,255).')';
																											echo  "{
																														label: '".$key."',
																														data: [".$Jan.",".$Feb.",".$Mar.",".$Apr.",".$May.",".$June.",".$July.",".$Aug.",".$Sept.",".$Oct.",".$Nov.",".$Dec."],
																														backgroundColor: ['".$color."','".$color."','".$color."','".$color."','".$color."','".$color."','".$color."','".$color."','".$color."','".$color."','".$color."','".$color."'],
																														borderColor: [
																																'rgba(255,99,132,1)',
																																'rgba(255,99,132,1)',
																																'rgba(255,99,132,1)',
																																'rgba(255,99,132,1)',
																																'rgba(255,99,132,1)',
																																'rgba(255,99,132,1)',
																																'rgba(255,99,132,1)',
																																'rgba(255,99,132,1)',
																																'rgba(255,99,132,1)',
																																'rgba(255,99,132,1)',
																																'rgba(255,99,132,1)',
																																'rgba(255,99,132,1)',
																																],
																																		borderWidth: 1
																																		},	";
																									}
																								}	
																									
																								
																									
																							}
																						}
																					?>
																					]
																		},
																		options: {
																			scales: {
																				yAxes: [{
																					ticks: {
																						beginAtZero:true
																					}
																				}]
																			}
																		}
																	});
														</script>
														</div>
													    </div>
										<?php 		}
												} ?>
								<?php     
								?>
						</div>
					</section>
                </div>   
              </section>    
          </div>
      </div>
  </section>
</section>

<link rel="stylesheet" href="<?php echo HTTP_SERVER;?>js/validation/css/validationEngine.jquery.css" type="text/css"/>
<script src="<?php echo HTTP_SERVER;?>js/validation/languages/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo HTTP_SERVER;?>js/validation/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>

<?php } else { 
		include(SERVER_ADMIN_PATH.'access_denied.php');
	}
?>