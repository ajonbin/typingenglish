<?php
  error_reporting(E_ALL ^ E_WARNING);
  $REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];
	//echo $REQUEST_METHOD;
	if($REQUEST_METHOD == 'POST'){
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
		$title = $_POST['title'];
    $content = $_POST['content'];
    
    /*
    echo $title;
    echo "<br>";
    echo $content;
    echo "<br>";
    */
    if(empty($title) or empty($content))
    {
      echo "{'success':'false','error_code':'6','error_msg':'文章不能为空'}";
      exit;
    }
    else
    {
      include "util.php";
     
    }       
    //Connect DB    
    include('connect_db.php');
    
    //Check username
    $check_query = mysql_query("select name from user where name='$name' limit 1");
    if(!mysql_fetch_array($check_query)){
      echo "{'success':'false','error_code':'2','error_msg':'用户不存在'}";
      exit;
    }
    
    $get_query = mysql_query("select * from articles where title='$title' limit 1");
    $result = mysql_fetch_array($get_query);
    
    if($result)
    {
      echo "{'success':'false','error_code':'2','error_msg':'文章已存在'}";
      exit;
    }
    $add_date = date('c');    
    $sql = "INSERT INTO articles(title,content,owner,date)VALUES('$title','$content','$name','$add_date')";    
        
    if(mysql_query($sql)){
      $aid = mysql_insert_id();
      $url = "../page_show_article.php?file=".$aid;
      header("Location: $url");       
    } else {
        echo mysql_error();
        echo "{'success':'false','error_code':'3','error_msg':'服务器内部错误'}";
    }
    mysql_free_result($result);
  
	}else if($REQUEST_METHOD == 'GET'){
		
	}
  
  mysql_close();
?>