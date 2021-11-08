<?php
  error_reporting(E_ALL ^ E_WARNING);
  $REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];
	//echo $REQUEST_METHOD;
	if($REQUEST_METHOD == 'GET'){
	}else if($REQUEST_METHOD == 'POST'){
		$name = $_POST['username'];
		$pwd = $_POST['password'];
       
    //Connect DB    
    include('connect_db.php');
    
    $check_query = mysql_query("select name from user where name='$name' limit 1");
    if(mysql_fetch_array($check_query)){
      echo "{'success':'false','error_code':'1','error_msg':'用户名已存在'}";
      exit;
    }
    $regdate = time();
    $sql = "INSERT INTO user(name,password,reg_date)VALUES('$name','$pwd','$regdate')";
    if(mysql_query($sql)){
        echo "{'success':'true'}";
    } else {
        echo "{'success':'false','error_code':'2','error_msg':'服务器内部错误'}";
    }     
	}
?>