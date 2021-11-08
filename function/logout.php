<?php
  error_reporting(E_ALL ^ E_WARNING);
  $REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];
	
  session_start();
  //这种方法是将原来注册的某个变量销毁
  unset($_SESSION['username']);
  //这种方法是销毁整个 Session 文件
  session_destroy();
  
  //Clear cookie
  if(!empty($_COOKIE['username']) || empty($_COOKIE['password'])){ 
    setcookie("username", null, time()-3600*24*365); 
    setcookie("password", null, time()-3600*24*365); 
  } 
	
  header("Location: ../index.php");
?>