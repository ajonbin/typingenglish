<?php
  error_reporting(E_ALL ^ E_WARNING);
  $REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];
	//echo $REQUEST_METHOD;
	if($REQUEST_METHOD == 'GET'){

	}else if($REQUEST_METHOD == 'POST'){
		$name = $_POST['username'];
		$password = $_POST['password'];
    $auto_login = $_POST['auto_login'];

    //Connect DB    
    include('connect_db.php');
    
    //检测用户名及密码是否正确
    $check_query = mysql_query("select name from user where name='$name' and password='$password' limit 1");
    if($result = mysql_fetch_array($check_query)){
        session_start();
        //登录成功
        $_SESSION['username'] = $name;
        
        //set cookie
        if($auto_login)
        {
          setcookie("username", $name, time()+3600*24*365); 
          setcookie("password", $password, time()+3600*24*365);
        }
        echo "{'success':'true'}";
        //$_SESSION['userid'] = $result['uid'];
    } else {
      echo "{'success':'false'}";
    }
    //header("Location: ./index.php");
	}
?>