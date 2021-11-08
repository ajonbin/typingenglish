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
		$del_word = $_GET['del_word'];
       
    //Connect DB    
    include('connect_db.php');
    
    $get_query = mysql_query("select * from new_words where user='$name' limit 1");
    $result = mysql_fetch_array($get_query);
    
    $legacy_words = array();
    $updated_words = "";
        
    if($result)
    {
      $legacy_words = (array)json_decode($result['new_words']);
      if(isset($legacy_words[$del_word]))
      {
        unset($legacy_words[$del_word]);
        $updated_words = json_encode($legacy_words);
        $sql = "UPDATE new_words SET new_words='$updated_words' WHERE user='$name'";
        
        //echo $updated_words;
        
        if(mysql_query($sql)){
            echo "{'success':'true','new_words':'$updated_words'}";
        } else {
            echo mysql_error();
            echo "{'success':'false','error_code':'4','error_msg':'服务器内部错误'}";
        }
      }
      mysql_free_result($result);      
    }
    mysql_close();

	}else if($REQUEST_METHOD == 'POST'){
		
	}
  
  mysql_close();
?>