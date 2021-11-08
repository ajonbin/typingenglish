<?php
  error_reporting(E_ALL ^ E_WARNING);
  $REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];
	//echo $REQUEST_METHOD;
	if($REQUEST_METHOD == 'GET'){
    session_start();
    if(isset($_SESSION['username']))
    {
      $name = $_SESSION['username'];
    }
    else
    {
      echo "{'success':'false','error_code':'3','error_msg':'请登录'}";
      exit;
    }
		$new_word = $_GET['new_word'];
       
    //Connect DB    
    include('connect_db.php');
    
    //Check username
    $check_query = mysql_query("select name from user where name='$name' limit 1");
    if(!mysql_fetch_array($check_query)){
      echo "{'success':'false','error_code':'2','error_msg':'用户不存在'}";
      exit;
    }
    
    $get_query = mysql_query("select * from new_words where user='$name' limit 1");
    $result = mysql_fetch_array($get_query);
    
    $legacy_words = array();
    $updated_words = "";
    $add_date = date('c');
    
    if($result)
    {
      $legacy_words = (array)json_decode($result['new_words']);
    }
   
    $legacy_words[$new_word]= $add_date;
    $updated_words = json_encode($legacy_words);
    
    if($result)
    {
      $sql = "UPDATE new_words SET new_words='$updated_words' WHERE user='$name'";
    }
    else
    {
      $sql = "INSERT INTO new_words(user,new_words)VALUES('$name','$updated_words')";
    }
   
    if(mysql_query($sql)){
        echo "{'success':'true'}";
    } else {
        echo mysql_error();
        echo "{'success':'false','error_code':'3','error_msg':'服务器内部错误'}";
    }
  
	}else if($REQUEST_METHOD == 'POST'){
		
	}
  
  mysql_close();
?>