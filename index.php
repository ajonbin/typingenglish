<!doctype html>

<html>

<head>
<title>Typing Enghils - Home</title>
<script language="javascript" src="./js/md5.js"></script>
<script language="javascript" src="./js/util.js"></script>

<?php include("head.htm"); ?>

<style type="text/css">
</style>

<script type="text/javascript">
</script>
</head>

<body onload="getNavigatorVersion();">

<!--header-->
<?php include("header.php"); ?>

<!--main begin-->
<div class="body-main">
  <div style="width:inherit;height:50px"></div>  
	<div class="brand-pic">
  	<div style="width:1024px;height:600px;border:50px;padding:0px;margin:0px;overflow:visible;float:left">
    <?php include("inner_list_articles.php"); ?>
  	</div>
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