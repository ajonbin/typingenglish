<!doctype html>

<html>

<head>
<title>Typing Enghils - Typing</title>
<?php include("head.htm"); ?>

<style type="text/css">
</style>
<script language="javascript" src="./js/md5.js"></script>
<script language="javascript" src="./js/util.js"></script>
<script type="text/javascript">
/*********** Dict & New Word *************/
  var g_word;
  document.onmousedown = function()
  {
    if(isMouseInDiv(document.getElementById("div_menu")))
    {
      document.getElementById("div_dict").style.display="none";
    }
    else if( isMouseInDiv(document.getElementById("div_dict")))
    {
      document.getElementById("div_menu").style.display="none";
    }
    else
    {
      document.getElementById("div_menu").style.display="none";
      document.getElementById("div_dict").style.display="none";
    }
 
  }
  
  function onDict()
  {
    var divDict = document.getElementById("div_dict");
    var divSelect = document.getElementById("div_menu");
    var iframeDict = document.getElementById("iframe_dict");
    var urlDict = "http://dict.cn/hc2/dict.php?skin=default&q=";
    
    divSelect.style.display = "none";
    divDict.style.display = "block";
    divDict.style.left = divSelect.style.left;
    divDict.style.top = divSelect.style.top;
    iframeDict.src = urlDict + g_word;
  }
  function delNewWordAjax()  
  {     
    var url = "./function/del_new_word.php?";
    var getStr = "del_word=" + g_word;
    xmlHttp.open("GET", url + getStr, true);
    xmlHttp.onreadystatechange=function()  
    {  
        if (4==xmlHttp.readyState)  
        {  
            if (200==xmlHttp.status)  
            {                                  
                var responseText = xmlHttp.responseText;
                //alert(responseText);
                var rs_json = eval('('+ responseText +')');
                if(rs_json['success'] == 'false')
                {
                  alert("请先登录");
                  window.location.replace("./page_login.php");  
                }
                else
                {
                  document.getElementById("div_menu").style.display="none";
                  
                  //alert(rs_json['new_words']);
                  var array_words = eval('(' + rs_json['new_words'] + ')');
                  
                  var innerHtml = "";
                  for (var item in array_words)
                  {
                    innerHtml += "<a href=\"#\" onclick=\"onClickWord(\'" + item + "\');return false\">" + item + "</a><br/>";
                  }
                  document.getElementById("div_list").innerHTML=innerHtml;
                }  
            }  
            else  
            {  
                alert("操作失败，请稍候重试");  
            }  
        }  
    }
    //定义传输的文件HTTP头信息
    xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    //发送POST数据
    xmlHttp.send(null);  
  }
  function onDelNewWord()
  {
    delNewWordAjax();  
  }
  
  
  
  function onClickWord(word)
  {                    
    var divMenu = document.getElementById("div_menu");
    divMenu.style.display="block";
    divMenu.style.left = getMousePosX() + "px";
    divMenu.style.top = (getMousePosY() + 10) + "px"; 
    
    var divDict = document.getElementById("div_dict");
    var iframeDict = document.getElementById("iframe_dict");
    var urlDict = "http://dict.cn/hc2/dict.php?skin=default&q=";

    g_word = word;
    
  }
  
  
</script>
</head>

<body bgColor="white">

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
        $get_query = mysql_query("select * from new_words where user='$username' limit 1");
        $result = mysql_fetch_array($get_query);
        if($result)
        {
          $words = (array)json_decode($result['new_words']);
          foreach($words as $k=>$v){
            echo "<a href=\"#\" onclick=\"onClickWord('$k');return false\">$k</a><br/>"; 
          }
          mysql_free_result($result);  
        }
        else
        {
          echo "您还没有添加生词<br/>";
        }
        
        mysql_close();
        
      ?>
  	</div>
    <div style="width:50px;height:100px;border:50px;padding:0px;margin:0px;overflow:hidden;float:left"></div>
  
    <div style="width:200px;border:50px;padding:0px;margin:0px;overflow:hidden">
    <?php include("setting.php"); ?>
    </div>
    
    <!-- Div for Selection -->
    <div id="div_menu" style="position:absolute;display:none;background:#99D9EA;padding:1px 5px 2px;border:1px solid">
      <a href="#" onclick="onDelNewWord();return false" style="color:black">删除</a>
      |                                                               
      <!-- return false means not to scroll to the top while clicked -->
      <a href="#" onclick="onDict();return false" style="color:black">查海词</a> 
    </div>
    <div id="div_dict" style="position:absolute;background:white;display:none;padding:1px 5px 2px;border:1px solid">
      <iframe id="iframe_dict" width="100%" height="100%" frameborder="0"></iframe>
    </div>
                         
  </div>  
</div>

<!--main end-->

<!--footer-->
<?php include("footer.php"); ?>

</body>
</html>

















