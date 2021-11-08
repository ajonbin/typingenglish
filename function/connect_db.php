<?php
  //$conn = mysql_connect("112.65.245.208","typingenglish_f","!123456!");
  $conn = mysql_connect("localhost","typingen_admin","J7xXkx!Ca(sJ");
  if (!$conn){
    die("连接数据库失败：" . mysql_error());
  }
  //mysql_select_db("typingenglish", $conn);
  if(!mysql_select_db("typingen_main", $conn))
  {
    die(mysql_error());
  }
  //字符转换，读库
  //mysql_query("set character set 'gbk'");
  //写库
  //mysql_query("set names 'gbk'");
?>