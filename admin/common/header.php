
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Focus Admin: Creative Admin Dashboard</title>
        <!-- ================= Favicon ================== -->
        <!-- Standard -->
        <link rel="shortcut icon" href="https://placehold.it/64.png/000/fff">
        <!-- Retina iPad Touch Icon-->
        <link rel="apple-touch-icon" sizes="144x144" href="https://placehold.it/144.png/000/fff">
        <!-- Retina iPhone Touch Icon-->
        <link rel="apple-touch-icon" sizes="114x114" href="https://placehold.it/114.png/000/fff">
        <!-- Standard iPad Touch Icon-->
        <link rel="apple-touch-icon" sizes="72x72" href="https://placehold.it/72.png/000/fff">
        <!-- Standard iPhone Touch Icon-->
        <link rel="apple-touch-icon" sizes="57x57" href="https://placehold.it/57.png/000/fff">
        <!-- Styles -->
        <link href="<?php echo HTTP_SERVER;?>assets/css/lib/calendar2/semantic.ui.min.css" rel="stylesheet">
        <link href="<?php echo HTTP_SERVER;?>assets/css/lib/calendar2/pignose.calendar.min.css" rel="stylesheet">
       <!--  <link href="<?php// echo HTTP_SERVER;?>assets/css/lib/chartist/chartist.min.css" rel="stylesheet"> -->
        <link href="<?php echo HTTP_SERVER;?>assets/css/lib/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo HTTP_SERVER;?>assets/css/lib/themify-icons.css" rel="stylesheet">
        <link href="<?php echo HTTP_SERVER;?>assets/css/lib/owl.carousel.min.css" rel="stylesheet" />
        <link href="<?php echo HTTP_SERVER;?>assets/css/lib/owl.theme.default.min.css" rel="stylesheet" />
        <link href="<?php echo HTTP_SERVER;?>assets/css/lib/weather-icons.css" rel="stylesheet" />
        <link href="<?php echo HTTP_SERVER;?>assets/css/lib/menubar/sidebar.css" rel="stylesheet">
        <link href="<?php echo HTTP_SERVER;?>assets/css/lib/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo HTTP_SERVER;?>assets/css/lib/helper.css" rel="stylesheet">
        <link href="<?php echo HTTP_SERVER;?>assets/css/style.css" rel="stylesheet">
        <link href="<?php echo HTTP_SERVER;?>assets/css/pagination.css" rel="stylesheet">
             
            <script src="<?php echo HTTP_SERVER;?>assets/js/lib/jquery.min.js"></script>
           <script src="<?php echo HTTP_SERVER;?>assets/js/lib/bootstrap.min.js"></script>
            <script src="<?php echo HTTP_ADMIN;?>common/common.js"></script>
          
    </head>

    <body>
<?php 
$activeController = $route;
$total_master_menu = $obj_general->getTotalMenuCout();
$menu_data = $obj_general->getMenu();

//printr($menu_data);
//printr($total_master_menu);
$menu_html='';
?>
        <div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
            <div class="nano">
                <div class="nano-content">
                   <?php if($total_master_menu > 0){?> 
                    <ul>
                        <div class="logo"><a href="index.html"> <img src="<?php echo HTTP_SERVER;?>assets/images/1.png" alt="" /><span>Focus</span></a></div>
                        <li class=""><a href="<?php echo $obj_general->link('dashboard', '', '',1)?>">Dashboard</a></li>
                       <?php   foreach($menu_data as $menu){

                            //print_r($menu);
                          if($obj_general->checkUser()){
                            if($obj_general->hasMainMenuPermission($menu['admin_menu_id'])){
                                if($menu['controller']){
                                    $set_rout = $obj_general->link($menu['controller'], '', '',1);//HTTP_ADMIN.'index.php?rout='.$menu['controller'];
                                }else{
                                    $set_rout = 'javascript:void(0);';
                                }
                              //  $menu_html .= '<li class="dropdown-submenu"><a href="' .$set_rout. '"><span>' .$menu['name']. '</span></a>';
                                   $menu_html .= $obj_general->nestedMenu($menu['admin_menu_id']);
                            //  $menu_html .= '</li>';  
                               // $menu_html .= '<li class="nav-divider-none"></li>';
                         
                        ?>
                                 <li class=""><a class="sidebar-sub-toggle" href="<?php echo $set_rout;?>"> <?php echo $menu['name']; ?><span class="sidebar-collapse-icon ti-angle-down"></span></a>
                              <?php  echo $obj_general->nestedMenu($menu['admin_menu_id']);?>

                          <!--   <ul>
                                <li><a href="index.html">Dashboard 1</a></li>
                                <li><a href="index1.html">Dashboard 2</a></li>
                            </ul> -->
                        </li>
                     <?php 

                             }
                         } else {
                                if($menu['controller']){
                                   $set_rout = $obj_general->link($menu['controller'], '', '',1);//HTTP_ADMIN.'index.php?rout='.$menu['controller'];
                               }else{
                                 $set_rout = 'javascript:void(0);';
                                     }

                                    ?>  <li class=""><a class="sidebar-sub-toggle" href="<?php echo $set_rout;?>"> <?php echo $menu['name']; ?><span class="sidebar-collapse-icon ti-angle-down"></span></a>
                                        <?php  echo $obj_general->nestedMenu($menu['admin_menu_id']);?>

                                        
                                     </li><?php 

                            }




                     } ?> 
                     
                    </ul>
                <?php }?>


                </div>
            </div>
        </div>
        <!-- /# sidebar -->

        <div class="header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                       <!--  <div class="float-left">
                            <div class="hamburger sidebar-toggle">
                                <span class="line"></span>
                                <span class="line"></span>
                                <span class="line"></span>
                            </div>
                        </div> -->
                        <div class="float-right">
                            <ul>

                                <li class="header-icon dib"><i class="ti-bell"></i>
                                    <div class="drop-down">
                                        <div class="dropdown-content-heading">
                                            <span class="text-left">Recent Notifications</span>
                                        </div>
                                        <div class="dropdown-content-body">
                                            <ul>
                                                <li>
                                                    <a href="#">
													<img class="pull-left m-r-10 avatar-img" src="<?php echo HTTP_SERVER;?>assets/images/avatar/3.jpg" alt="" />
													<div class="notification-content">
														<small class="notification-timestamp pull-right">02:34 PM</small>
														<div class="notification-heading">Mr. John</div>
														<div class="notification-text">5 members joined today </div>
													</div>
												</a>
                                                </li>
                                                <li>
                                                    <a href="#">
													<img class="pull-left m-r-10 avatar-img" src="<?php echo HTTP_SERVER;?>assets/images/avatar/3.jpg" alt="" />
													<div class="notification-content">
														<small class="notification-timestamp pull-right">02:34 PM</small>
														<div class="notification-heading">Mariam</div>
														<div class="notification-text">likes a photo of you</div>
													</div>
												</a>
                                                </li>
                                                <li>
                                                    <a href="#">
													<img class="pull-left m-r-10 avatar-img" src="<?php echo HTTP_SERVER;?>assets/images/avatar/3.jpg" alt="" />
													<div class="notification-content">
														<small class="notification-timestamp pull-right">02:34 PM</small>
														<div class="notification-heading">Tasnim</div>
														<div class="notification-text">Hi Teddy, Just wanted to let you ...</div>
													</div>
												</a>
                                                </li>
                                                <li>
                                                    <a href="#">
													<img class="pull-left m-r-10 avatar-img" src="<?php echo HTTP_SERVER;?>assets/images/avatar/3.jpg" alt="" />
													<div class="notification-content">
														<small class="notification-timestamp pull-right">02:34 PM</small>
														<div class="notification-heading">Mr. John</div>
														<div class="notification-text">Hi Teddy, Just wanted to let you ...</div>
													</div>
												</a>
                                                </li>
                                                <li class="text-center">
                                                    <a href="#" class="more-link">See All</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <li class="header-icon dib"><i class="ti-email"></i>
                                    <div class="drop-down">
                                        <div class="dropdown-content-heading">
                                            <span class="text-left">2 New Messages</span>
                                            <a href="email.html"><i class="ti-pencil-alt pull-right"></i></a>
                                        </div>
                                        <div class="dropdown-content-body">
                                            <ul>
                                                <li class="notification-unread">
                                                    <a href="#">
													<img class="pull-left m-r-10 avatar-img" src="<?php echo HTTP_SERVER;?>assets/images/avatar/1.jpg" alt="" />
													<div class="notification-content">
														<small class="notification-timestamp pull-right">02:34 PM</small>
														<div class="notification-heading">Michael Qin</div>
														<div class="notification-text">Hi Teddy, Just wanted to let you ...</div>
													</div>
												</a>
                                                </li>
                                                <li class="notification-unread">
                                                    <a href="#">
													<img class="pull-left m-r-10 avatar-img" src="<?php echo HTTP_SERVER;?>assets/images/avatar/2.jpg" alt="" />
													<div class="notification-content">
														<small class="notification-timestamp pull-right">02:34 PM</small>
														<div class="notification-heading">Mr. John</div>
														<div class="notification-text">Hi Teddy, Just wanted to let you ...</div>
													</div>
												</a>
                                                </li>
                                                <li>
                                                    <a href="#">
													<img class="pull-left m-r-10 avatar-img" src="<?php echo HTTP_SERVER;?>assets/images/avatar/3.jpg" alt="" />
													<div class="notification-content">
														<small class="notification-timestamp pull-right">02:34 PM</small>
														<div class="notification-heading">Michael Qin</div>
														<div class="notification-text">Hi Teddy, Just wanted to let you ...</div>
													</div>
												</a>
                                                </li>
                                                <li>
                                                    <a href="#">
													<img class="pull-left m-r-10 avatar-img" src="<?php echo HTTP_SERVER;?>assets/images/avatar/2.jpg" alt="" />
													<div class="notification-content">
														<small class="notification-timestamp pull-right">02:34 PM</small>
														<div class="notification-heading">Mr. John</div>
														<div class="notification-text">Hi Teddy, Just wanted to let you ...</div>
													</div>
												</a>
                                                </li>
                                                <li class="text-center">
                                                    <a href="#" class="more-link">See All</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                       <?php 
                        
                            if(is_loginAdmin()){ 
                                if(SYSTEM_LOCK) { 
                                    if($obj_session->data['LOGIN_USER_TYPE']==1 && $obj_session->data['ADMIN_LOGIN_SWISS']==1){ 
                                        $display=1;
                                    } else { 
                                        $display=0;
                                    }
                                }else{
                                    $display=1;
                                }
                            }else{
                                $display = 1;
                            }



                       ?>         
            <?php if(isset($obj_session->data['ADMIN_LOGIN_SWISS']) && (int)$obj_session->data['ADMIN_LOGIN_SWISS'] > 0 && $display){ ?>  
                                <li class="header-icon dib"><span class="user-avatar"> <?php echo isset($obj_session->data['ADMIN_LOGIN_NAME'])?$obj_session->data['ADMIN_LOGIN_NAME']:'Admin';?> <i class="ti-angle-down f-s-10"></i></span>
                                    <div class="drop-down dropdown-profile">
                                        <input type="hidden" name="user_id" id="user_id" value="<?php echo isset($obj_session->data['ADMIN_LOGIN_SWISS'])?$obj_session->data['ADMIN_LOGIN_SWISS']:'';?>" >
                                      
                                        <div class="dropdown-content-body">
                                            <ul>
                                                <li><a href="#"><i class="ti-user"></i> <span>Profile</span></a></li>

                                                <li><a href="#"><i class="ti-email"></i> <span>Inbox</span></a></li>
                                                <li><a href="#"><i class="ti-settings"></i> <span>Setting</span></a></li>                                               
                                                <li><a href="signout.php"><i class="ti-power-off"></i> <span>Logout</span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>

                            <?php }?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-wrap">
           
       