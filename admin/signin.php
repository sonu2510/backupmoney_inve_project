
<?php include_once("../ps-config.php"); 

include('model/user.php');
$obj_user = new user;

if(isset($_SESSION['history_id'])){
	//printr($_SESSION['history_id']);die;
	$obj_user->insertDuration($_SESSION['history_id']);
	unset($_SESSION['history_id']);					
}

if(is_loginAdmin()){
//	printr(is_loginAdmin);die;
	page_redirect(HTTP_ADMIN.'index.php?rout=dashboard');
}

$error = '';
if(isset($_POST['btn_submit'])){

	//print_r($_POST);die;
	$user_name = $_POST['user_name'];
	$password = $_POST['password'];
	if($user_name && $password){
		
		$data = $obj_user->checkUserNamePassword($user_name,$password);
		
	//	print_r($data);die;
		if($data){
			
			
			
			if($data['status'] == 1){
				
				$getuser = $obj_user->getUser($data['user_type_id'],$data['user_id']);
				
				$obj_session->data['token'] = md5(mt_rand());
				if($data['user_type_id'] == 1){
					$obj_session->data['ADMIN_LOGIN_SWISS'] = $data['user_id'];
					$obj_session->data['DEPARTMENT'] = $data['department'];
				}elseif($data['user_type_id'] == 2){
					$obj_session->data['ADMIN_LOGIN_SWISS'] = $data['employee_id'];
				}elseif($data['user_type_id'] == 3){
					$obj_session->data['ADMIN_LOGIN_SWISS'] = $data['client_id'];
				}elseif($data['user_type_id'] == 4){
					$obj_session->data['ADMIN_LOGIN_SWISS'] = $data['international_branch_id'];
				}elseif($data['user_type_id'] == 5){
					$obj_session->data['ADMIN_LOGIN_SWISS'] = $data['associate_id'];
				}
				$obj_session->data['ADMIN_LOGIN_NAME'] = $data['first_name'].' '.$data['last_name'];
				$obj_session->data['ADMIN_LOGIN_EMAIL_SWISS']  = $data['email'];
				$obj_session->data['LOGIN_USER_TYPE'] = $data['user_type_id'];
				$obj_session->data['ADMIN_LOGIN_USER_TYPE'] = isset($data['admin_type_id'])?$data['admin_type_id']:'';
				$obj_session->data['ADMIN_LOGIN_USER'] = $data['user_name'];
				$obj_session->data['USER_COUNTRY'] = $getuser['country_id'];
				$obj_session->data['last_login_timestamp']=time();
				
//echo 'wefgqg';die;
				$obj_session->data['show_warning']=1;
				page_redirect(HTTP_ADMIN.'index.php?rout=dashboard');
				
			}else{
				$obj_session->data['warning'] = 'Your account is inactive!';
			}
		}else{
			$obj_session->data['warning'] = 'Wrong user name and password!';
		}
	}else{
		$obj_session->data['warning'] = 'Please enter user name and password !';
	}
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Focus Admin: Basic Form </title>

    <!-- ================= Favicon ================== -->
    <!-- Standard -->
    <link rel="shortcut icon" href="http://placehold.it/64.png/000/fff">
    <!-- Retina iPad Touch Icon-->
    <link rel="apple-touch-icon" sizes="144x144" href="http://placehold.it/144.png/000/fff">
    <!-- Retina iPhone Touch Icon-->
    <link rel="apple-touch-icon" sizes="114x114" href="http://placehold.it/114.png/000/fff">
    <!-- Standard iPad Touch Icon-->
    <link rel="apple-touch-icon" sizes="72x72" href="http://placehold.it/72.png/000/fff">
    <!-- Standard iPhone Touch Icon-->
    <link rel="apple-touch-icon" sizes="57x57" href="http://placehold.it/57.png/000/fff">

    <!-- Styles -->
    <link href="<?php echo HTTP_SERVER;?>assets/css/lib/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo HTTP_SERVER;?>assets/css/lib/themify-icons.css" rel="stylesheet">
    <link href="<?php echo HTTP_SERVER;?>assets/css/lib/menubar/sidebar.css" rel="stylesheet">
    <link href="<?php echo HTTP_SERVER;?>assets/css/lib/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo HTTP_SERVER;?>assets/css/lib/helper.css" rel="stylesheet">
    <link href="<?php echo HTTP_SERVER;?>assets/css/style.css" rel="stylesheet">
</head>


<body class="bg-primary">

    <div class="unix-login">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="login-content">
                        <div class="login-logo">
                            <a href="index.html"><span>Focus</span></a>
                        </div>
                        <div class="login-form">
                            <h4> Login</h4>
                            <form name="frm_signin" id="frm_signin" class="panel-body" method="post">
                                <div class="form-group">
                                    <label>User Name</label>
                                    <input type="text"  name="user_name" class="form-control" placeholder="User Name">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password"  name="password" class="form-control" placeholder="Password">
                                </div>
                                <div class="checkbox">
                                    <label>
										<input type="checkbox"> Remember Me
									</label>
                                    <label class="pull-right">
										<a href="#">Forgotten Password?</a>
									</label>

                                </div>
                                <button type="submit"  name="btn_submit" id="btn_submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Sign in</button>
                              
                               
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>