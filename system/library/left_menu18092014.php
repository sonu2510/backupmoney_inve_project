<nav id="nav" class="nav-primary hidden-xs nav-vertical">

<?php

$total_master_menu = $obj_general->getTotalMenuCout();
$menu_data = $obj_general->getMenu();
//printr($menu_data);die;
$menu_html = '';
	if($total_master_menu > 0){
		$menu_html .= '<ul class="nav" data-spy="affix" data-offset-top="50">';
			foreach($menu_data as $menu){
				//echo '<li class="active"><a href="javascript:void(0);"><span>Dashboard</span></a></li>';
				
				/*if(checkUser()){
						if(hasMainMenuPermission($results_menu[$i]['id'])){
							if($results_menu[$i]['controller_name']){
								$set_mod_link = 'index.php?mod='.$results_menu[$i]['controller_name'];
							}else{
								$set_mod_link = 'javascript:void(0);';
							}
							echo '<li> <a class="dropmenu" href="'.$set_mod_link.'"><i class="fa fa-file-text"></i><span class="hidden-sm">'.$results_menu[$i]['name'].'</span> <span class="label"><i class="fa fa-chevron-circle-down"></i></span></a>';	
							
							menu_showNested_left($results_menu[$i]['id']);
							
							echo "</li>";
						}
				} else {*/
					if($menu['controller']){
						$set_rout = HTTP_ADMIN.'index.php?rout='.$menu['controller'];
					}else{
						$set_rout = 'javascript:void(0);';
					}
					//active
					$sub_menu_count = $obj_general->getNestedMenuCount($menu['admin_menu_id']);
					if($sub_menu_count){
						$menu_html .= '<li class="dropdown-submenu"><a href="' .$set_rout. '"><span>' .$menu['name']. '</span></a>';
							$sub_menu_data = $obj_general->nestedMenu($menu['admin_menu_id']);
							$menu_html .= '<ul class="dropdown-menu">';
							foreach($sub_menu_data as $sub_menu){
								if($sub_menu['mod']){
									$menu_html .= '<li><a href="'.HTTP_ADMIN.'index.php?rout='.$sub_menu['controller'].'&mod='.$sub_menu['mod'].'">'.$sub_menu['name'].'</a></li>';
								}else{
									$menu_html .= '<li><a href="'.HTTP_ADMIN.'index.php?rout='.$sub_menu['controller'].'">'.$sub_menu['name'].'</a></li>';
								}
							}
							$menu_html .= '</ul>';
						$menu_html .= '</li>';
					}else{
						$menu_html .= '<li class=""><a href="' .$set_rout. '"><span>' .$menu['name']. '</span></a></li>';
					}
					$menu_html .= '<li class="nav-divider-none"></li>';
				//}
				
			}
		$menu_html .= '</ui>';
	}else{
		
	}
	echo $menu_html;
?>
    
  <?php /* <ul class="nav" data-spy="affix" data-offset-top="50">
  	
    <li class="active"><a href="javascript:void(0);"><span>Dashboard</span></a></li>
    <!--<div class="line line-dashed m-t-none m-b-none"></div>-->
    <!--<li class="line m-t-none m-b-none"></li>-->
    <li class="nav-divider-none"></li>
   
    <li class="dropdown-submenu"> <a href="javascript:void(0);"><span>User</span></a>
      <ul class="dropdown-menu">
        <li><a href="<?php HTTP_ADMIN;?>index.php?rout=user">User</a></li>
        <li><a href="<?php HTTP_ADMIN;?>index.php?rout=department">Department</a></li>
      </ul>
    </li>
	<li class="nav-divider-none"></li>
    
    <li class="dropdown-submenu"> <a href="javascript:void(0);"><span>Employee</span></a>
      <ul class="dropdown-menu">
        <li><a href="<?php HTTP_ADMIN;?>index.php?rout=employee">Employee List</a></li>
        <li><a href="<?php HTTP_ADMIN;?>index.php?rout=addemployee">Add Employee</a></li>
      </ul>
    </li>
    <li class="nav-divider-none"></li>
      
    <li class="dropdown-submenu"> <a href="javascript:void(0);"><span>User Group</span></a>
      <ul class="dropdown-menu">
        <li><a href="<?php HTTP_ADMIN;?>index.php?rout=usergrouplist">User Group List</a></li>
        <li><a href="<?php HTTP_ADMIN;?>index.php?rout=addusergroup">Add User Group </a></li>
      </ul>
    </li>
    <li class="nav-divider-none"></li>
    
  </ul>*/?>
  </nav>
<!-- / nav -->