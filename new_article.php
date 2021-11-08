<!doctype html>

<html>

<head>
<?php include("head.htm"); ?>
<title>Typing English - New Article</title>

<style type="text/css">
</style>

</head>

<body >

<!--header-->
<?php include("header.php"); ?>

<!--main begin-->
<div class="body-main">
  <div style="width:inherit;height:50px"></div>    
	<div class="brand-pic">
    <div style="width:200px;border:50px;padding:0px;margin:0px;overflow:hidden;float:left">
    <?php include("inner_list_articles.php"); ?>
    </div>
    <div style="width:50px;height:100px;border:50px;padding:0px;margin:0px;overflow:hidden;float:left"></div>
                                                               
  	<div style="width:780px;border:50px;padding:0px;margin:0px;overflow:hidden;;float:left">
      <form action="./function/add_new_article.php" method="post">
      Title<br>
      <input name="title" type="text" style="width:700px"></input><br>
      <br>
      Content<br>
      <textarea name="content" style="overflow:auto;width:700px;height:500px"></textarea>
      <center>
      <button onclick="subForm()">提交</button>
      <button onclick="form.reset();return false;">清空</button>
      </center>
      </form>
      <br>
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


















<!doctype html>

<html>

<head>

<meta charset="UTF-8"/>

<title>Ajonbin.com</title>

<meta name="keywords" content="Typing English @ ajonbin.com"/>

<link href="./css/location.css" rel="stylesheet" type="text/css" />


</head>

<body bgcolor="white">



</body>
</html>