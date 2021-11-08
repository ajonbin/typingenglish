<!doctype html>

<html>

<head>
<title>Typing Enghils - Typing</title>
<?php include("head.htm"); ?>

<style type="text/css">
</style>
<script language="javascript" src="./js/md5.js"></script>
<script language="javascript" src="./js/util.js"></script>
</head>

<body bgColor="white">

<!--header-->
<?php include("header.php"); ?>

<!--main begin-->
<div class="body-main">
  <div style="width:inherit;height:50px"></div>    
	<div class="brand-pic">
                                                               
  	<div id="div_list" style="width:780px;border:50px;padding:0px;margin:0px;overflow:hidden;;float:left">
      <?php
        if(!isset($_SESSION['username']))
        {
          echo "<script language='javascript'>";
          echo "gotoLink('./page_login.php')";
          echo "</script>";
          exit;
        }
        
        $username = $_SESSION['username'];
        //Connect DB    
        include('./function/connect_db.php');
        
        $get_query = mysql_query("SELECT aid, title FROM articles WHERE owner='$username'");
        $found = false;
        while ($row = mysql_fetch_array($get_query))
        {
          $found = true;
          echo "<a href=\"./page_show_article.php?file=".$row['aid']."\">".$row['title']."</a><br><br>";
        }
        
        if($found == false)
        {
          echo "您还没有添加文章<br/>";
        }
        
        mysql_free_result($get_query);
        mysql_close();
      ?>
  	</div>
    <div style="width:50px;height:100px;border:50px;padding:0px;margin:0px;overflow:hidden;float:left"></div>
  
    <div style="width:200px;border:50px;padding:0px;margin:0px;overflow:hidden">
    <?php include("setting.php"); ?>
    </div>

                         
  </div>  
</div>

<!--main end-->

<!--footer-->
<?php include("footer.php"); ?>

</body>
</html>

















