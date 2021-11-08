<?php
  error_reporting(E_ALL ^ E_WARNING);
  $REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];
	//echo $REQUEST_METHOD;
	if($REQUEST_METHOD == 'GET'){
  	$aid = $_GET['file'];
    $annotation = $_GET['annotation'];
  }else if($REQUEST_METHOD == 'POST'){
    $aid = $_POST['file'];
    $annotation = $_POST['annotation'];
	}
  //echo $annotation;
  //Check annotation
  if(empty($aid) or empty($annotation))
  {
    echo "{'success':'false','error_code':'6','error_msg':'文章不能为空'}";
  }
  else
  {
    include "util.php";
   
  }
  
  //==========================
  // Get Session Data
  //==========================
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

  //Connect DB    
  include('connect_db.php');
  
  //Get lagecy annotation
  $get_query = mysql_query("select annotation from articles where aid='$aid' limit 1");
  $result = mysql_fetch_array($get_query);
  $array_annotation = array();
  if($result)
  {
    $escaped_annotation = str_replace(PHP_EOL,"<br>",$result['annotation']);
    $array_annotation = (array)json_decode($escaped_annotation);
  }
  
  $array_new_annotation = array("user"=>$name,"annotation"=>$annotation,"date"=>date('c'));
  array_push($array_annotation,$array_new_annotation);
  //print_r($array_annotation);
  $js_annotation = json_encode($array_annotation);
  //Parse Chinese 
  $js_annotation = preg_replace("#\\\u([0-9a-f]{4})#ie", "iconv('UCS-2BE', 'UTF-8', pack('H4', '\\1'))", $js_annotation);
  //echo $js_annotation;
  $js_annotation = str_replace("\\\\","\\",$js_annotation); // Remove "\" for "\'"
  //echo $js_annotation;
  $sql = "UPDATE articles SET annotation='$js_annotation' WHERE aid='$aid'";
  if(mysql_query($sql)){
    echo "{'success':'true','annotation':'$js_annotation'}";
  } else {
    echo mysql_error();
    echo "{'success':'false','error_code':'4','error_msg':'服务器内部错误'}";
  }
  
  //Free Result
  mysql_free_result($result);
  mysql_close();
?>