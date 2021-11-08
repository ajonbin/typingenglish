<!doctype html>

<html>

<head>
<title>Typing Enghils - Forgot Password</title>
<script language="javascript" src="./js/md5.js"></script>
<script language="javascript" src="./js/util.js"></script>


<?php include("head.htm"); ?>

<style type="text/css">
</style>

<script type="text/javascript">
</script>
</head>

<body >
<!--header-->
<?php include("header.php"); ?>

<?php
  error_reporting(E_ALL ^ E_WARNING);
  $REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];
	//echo $REQUEST_METHOD;
	if($REQUEST_METHOD == 'GET'){

	}else if($REQUEST_METHOD == 'POST'){
    require_once ('./function/connect_db.php');
     
    echo $_POST['header_username'];
    $username = trim($_POST['header_username']);
    
    $sql="select name,password from user where name='$username'";
      
    $query=mysql_query($sql,$conn);  
    $num=mysql_num_rows($query);  
    $userinfo=mysql_fetch_array($query);
    
    if($num<=0){  
      echo "用户名 ".$username." 不存在";
    }else{ 
 
      $password = $userinfo['password'];
      $due_time = time() + 3600;
      $string = base64_encode($username."+".$password."+".$due_time);
      
      $array = explode('+',base64_decode($string));
      
      
      require_once ("./function/smtp.php");
      $smtpserver = "mail.typingenglish.com";//SMTP服务器  
      $smtpserverport = 26;//SMTP服务器端口  
      $smtpusermail = "admin@typingenglish.com";//SMTP服务器的用户邮箱  
      $smtpemailto = $username;//发送给谁  
      $smtpuser = "admin@typingenglish.com";//SMTP服务器的用户帐号  
      $smtppass = "J7xXkx!Ca(sJ";//SMTP服务器的用户密码  

      $mailsubject = "=?UTF-8?B?".base64_encode('[Typing English] 取回密码邮件')."?=";//邮件主题  
      $mailbody = <<< EOT
尊敬的{$username}先生/女士：<br />    取回密码邮件<br />请点击下面的链接，按流程进行密码重设。
<a href="http://www.ajonbin.com/typingenglish/reset_password.php?p={$string}">
  http://www.ajonbin.com/typingenglish/reset_password.php?p={$string}
</a><br>
(如果上面不是链接形式，请将地址手工粘贴到浏览器地址栏再访问)  
上面的页面打开后，输入新的密码后提交，之后您即可使用新的密码登录了。<br><br>此邮件为系统邮件，请勿直接回复
EOT;
        
      //邮件内容  
      $mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件  
      $smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.  
      $smtp->debug = false;//是否显示发送的调试信息  
      $smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype);
      echo $mailbody;
      echo "重置密码邮件已发送至".$username."，请及时查收";
     
    }    
    
  }  
  
?>

</body>
</html>