<?php
  error_reporting(E_ALL ^ E_WARNING);
  $REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];
  
  /*
	if($REQUEST_METHOD == 'GET'){
    $owner_type= $_POST['type'];
    
 	}else if($REQUEST_METHOD == 'GET'){
		$owner_type= $_GET['type'];
	}
  
  if(empty($owner_type))
  {
    $owner_type="all";  // all ; private  
  }
  */

  include('./function/connect_db.php');
  /*
  if($owner_type == "private")
  {
    session_start();
    if(isset($_SESSION['username']))
    {
      $name = $_SESSION['username'];
      //Check username
      $check_query = mysql_query("select name from user where name='$name' limit 1");
      if(!mysql_fetch_array($check_query)){
        echo "{'success':'false','error_code':'2','error_msg':'用户不存在'}";
        exit;
      }
    }
    else
    {
          
    }
    session_close();
  } 
  */   

  $get_query = mysql_query("select aid, title from articles");
  while ($row = mysql_fetch_array($get_query))
  {
    echo "<a href=\"./page_show_article.php?file=".$row['aid']."\">".$row['title']."</a><br><br>";
  }
  
  mysql_free_result($get_query);
  mysql_close();
?>