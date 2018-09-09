<?php
function clean($string)
{
	return htmlentities($string);
}
function redirect($location)
{
	return header("Location: {$location}");
}
function set_message($message)
{
	if (!empty($message))
	{
		$_SEESION['message'] = $message;
	}else{
		$message="";
	}
}
function display_message()
{
	if(isset($_SEESION['message']))
	{
		echo $_SEESION['message'];	
		unset($_SEESION['message']);
	}
}
function token_generator()
{
	$token = $_SEESION['token']=md5(uniqid(mt_rand(),true));
return $token;
}
function validate_errors($error_message)
{
	$error_message =<<<DELIMITER
				<div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Warning!</strong> $error_message
</div>
DELIMITER;
return $error_message;
}
function email_exists($email)
{
	$sql = "SELECT id FROM users WHERE email = '$email'";
	$result = query($sql);
	if(row_count($result)==1)
	{
		return true;
	}
	else{
		return false;
	}
}
function username_exists($username)
{
	$sql = "SELECT id FROM users WHERE username = '$username'";
	$result = query($sql);
	if(row_count($result)==1)
	{
		return true;
	}
	else{
		return false;
	}
}
function validate_user_registration()
{
	$errors= [];
	$min =2;
	$max =20;
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$first_name=clean($_POST['first_name']);
		$last_name=clean($_POST['last_name']);
		$username=clean($_POST['username']);
		$email=clean($_POST['email']);
		$password=clean($_POST['password']);
		$type=clean($_POST['type']);
		
		if(strlen($first_name) <$min)
		{
			$errors[] = "Your first name cannot be less than {$min} character";
		}
		if(empty($first_name))
		{
			$errors[]="Yours first name cannot be empty";
		}
		if(strlen($last_name) <$min)
		{
			$errors[] = "Your first last cannot be less than {$min} character";
		}
		
		if(!empty($errors))
		{
			foreach ($errors as $errors ) {
				# code...
				
				echo validate_errors($errors);
			}
		}
		else{
			if(register_user($first_name,$last_name,$username,$email,$password))
			{
				echo "REGISTERED";
			}
		}
	}
}
function validate_user()
{

	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$value=clean($_POST['value']);
		$values2=clean($_POST['values']);
		$values3=clean($_POST['values']);
		$values4=clean($_POST['values']);
		$values5=clean($_POST['values']);
		$values6=clean($_POST['values']);
		$values7=clean($_POST['values']);
		$values8=clean($_POST['values']);
		
			if(radio_user($value,$values2,$values3,$values4,$values5,$values6,$values7,$values8))
			{
				echo "REGISTERED";
			}
	}
}
function radio_user($value,$values2,$values3,$values4,$values5,$values6,$values7,$values8)
{
	$sql = "INSERT INTO radio(value,values2,values3,values4,values5,values6,values7,values8)VALUES('$value','$values2','$values3','$values4','$values5','$values6','$values7','$values8')";
	$result=query($sql);
	echo "string";
	confir($result);
}
function register_user($first_name,$last_name,$username,$email,$password)
{
	
	$sql = "INSERT INTO users(first_name,last_name,username,email,password)VALUES('$first_name','$last_name','$username','$email','$password')";
	$result=query($sql);
	confir($result);
	
}
function validate_user_login()
{
	$errors= [];
	$min =2;
	$max =20;
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		
		$email=clean($_POST['email']);
		$password=clean($_POST['password']);
		
		
		if(!empty($errors))
		{
			foreach ($errors as $errors ) {
				# code...
				
				echo validate_errors($errors);
			}
		}
		else{
			if(login_user($email,$password))
			{
				echo "string";
				redirect("index.html");
			}
			else
			{
				echo "BYEE";
			}
		}
	}
}
function validate_user_logint()
{
	$errors= [];
	$min =2;
	$max =20;
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		
		$email=clean($_POST['email']);
		$password=clean($_POST['password']);
		
		
		if(!empty($errors))
		{
			foreach ($errors as $errors ) {
				# code...
				
				echo validate_errors($errors);
			}
		}
		else{
			if(login_user($email,$password))
			{
				echo "string";
				redirect("teacher.php");
			}
			else
			{
				echo "BYEE";
			}
		}
	}
}
// function validate_user_login()
// {
// 	$errors= [];
// 	$min =2;
// 	$max =20;
// 	if($_SERVER['REQUEST_METHOD'] == "POST")
// 	{
// 		$email=clean($_POST['email']);
// 		$password=clean($_POST['password']);
// 	if(!empty($errors))
// 		{
// 			foreach ($errors as $errors ) {
// 				# code...
				
// 				echo validate_errors($errors);
// 			}
// 		}
// 		else{
// 			if(login_user($email,$password)
// 			{
// 				redirect("admin.php")
// 			}
// 		}	
// 	}			
// }		
function login_user($email,$password)
{
	
	$sql= "SELECT password,email,username FROM users WHERE email='$email'";
	$result=query($sql);
	$row=fetch_array($result);
	$db_name = $row['email'];
	$db_password =$row['password'];
	$db_names = $row['username'];
	$_SESSION['email']='email';
	disp($_SESSION['email']);
	if($db_password===$password)
	{
		// session_start();
		$_SESSION['username']=$db_names;
		$_SESSION['rows']=$row;

		return true;
	}
	else{
	}
}
function get_user_data(){
	// session_start();
	$username=$_SESSION['username'];
	$sql= "SELECT password,email,username,first_name,last_name FROM users WHERE username='$username'";
	$result=query($sql);
	$row=fetch_array($result);
	return $row;
}
function val_regist()
{

}
function logged_in()
{

	if(isset($_SESSION['username']))
	{
		return true;
	}
	else {
		return false;
	}
}
function disp($dbname)
{
	echo $dbname;
}
?>