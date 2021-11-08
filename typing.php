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
  //Set text select event
  document.onmouseup = function(){
    var selected = getSelectedText();
    if(isEleDisplay(document.getElementById("div_select"))
        ||isEleDisplay(document.getElementById("div_dict")))
    {
      
    } 
    else if(selected.length > 0)
    {
      
      var divSelect = document.getElementById("div_select");
      divSelect.style.display="block";
      divSelect.style.left = getMousePosX() + "px";
      divSelect.style.top = (getMousePosY() + 10) + "px"; 
    }   
  }
  
  document.onmousedown = function()
  {
    if(isMouseInDiv(document.getElementById("div_select")))
    {
      document.getElementById("div_dict").style.display="none";
    }
    else if( isMouseInDiv(document.getElementById("div_dict")))
    {
      document.getElementById("div_select").style.display="none";
    }
    else
    {
      document.getElementById("div_select").style.display="none";
      document.getElementById("div_dict").style.display="none";
    }
 
  }
  
  function onInputKeyDown(event,index)
  {
    if(event.keyCode==13||event.which==13)
    {
      var div_id = "div_" + index;
      var ele_div = document.getElementById(div_id);
      if(ele_div.style.color == document.body.bgColor)
      {
        ele_div.style.color = document.fgColor;
      }
      else if(ele_div.style.color == document.fgColor)
      {
        ele_div.style.color = document.body.bgColor;
      }
    }
    return true;
  }
  function showOrigin(ele_origin_div)
  {
    ele_origin_div.style.color = document.fgColor;
  }
   
  function checkTyped(index) 
  { 
    var div_id = "div_" + index;
    var form_id = "form_" + index;
    var ele_form = document.getElementById(form_id);
    var origin = document.getElementById(div_id).innerText;
    var typed = ele_form.typed.value;
    var img_checked_id = "img_checked_" + index;
    var img_error_id = "img_error_" + index;
    if(origin == typed)
    {
      document.getElementById(img_checked_id).style.display = "block";
      document.getElementById(img_error_id).style.display = "none";
    }
    else
    {
      if(typed)
      {
        document.getElementById(img_checked_id).style.display = "none";
        document.getElementById(img_error_id).style.display = "block";
      }
    }
  }
  function onBlurSubmit(index)
  {
    var div_id = "div_" + index;
    checkTyped(index);
    showOrigin(document.getElementById(div_id));
  }
  function onInputFocus(ele_input,index)
  {
    var div_id = "div_" + index;
    document.getElementById(div_id).style.color = document.body.bgColor;
  }
  function onDivClick(ele_div)
  {
    ele_div.style.color = document.fgColor;
  }
  
  function onDict()
  {
    var divDict = document.getElementById("div_dict");
    var divSelect = document.getElementById("div_select");
    var iframeDict = document.getElementById("iframe_dict");
    var urlDict = "http://dict.cn/hc2/dict.php?skin=default&q=";
    
    divSelect.style.display = "none";
    divDict.style.display = "block";
    divDict.style.left = divSelect.style.left;
    divDict.style.top = divSelect.style.top;
    iframeDict.src = urlDict + getSelectedText();
  }
  function addNewWordAjax()  
  {     
    var url = "./function/add_new_word.php?";
    var getStr = "new_word=" + getSelectedText();
    xmlHttp.open("GET", url + getStr, true);
    xmlHttp.onreadystatechange=function()  
    {  
        if (4==xmlHttp.readyState)  
        {  
            if (200==xmlHttp.status)  
            {                                  
                var responseText = xmlHttp.responseText;
                var rs_json = eval('('+ responseText +')');
                if(rs_json['success'] == 'false')
                {
                  alert("请先登录");
                  window.location.replace("./page_login.php");  
                }
                else
                {
                  document.getElementById("div_select").style.display="none";
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
  function onAddNewWord()
  {
    addNewWordAjax();  
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
                                                               
  	<div id="div_typing" style="width:780px;border:50px;padding:0px;margin:0px;overflow:hidden;;float:left">
      <?php
        function replace_new_line($str)
        {
          $order   = array("\r\n", "\n", "\r");   
          $replace = '';
          $str=str_replace($order, $replace, $str);
          return $str; 
        } 
        include "./function/util.php";
                          
        error_reporting(E_ALL ^ E_WARNING);
        $REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];
      
        //Get file content
        $aid = $_GET['file'];
        include('./function/connect_db.php');
        $get_query = mysql_query("select title,content from articles WHERE aid='$aid'");
        $row = mysql_fetch_array($get_query);
        mysql_free_result($get_query);
        mysql_close();
      
        //Show Content
        $name = $row['title'];
        //$name = Replace_Special_Char($name);
        $content = $row['content'];
        
        //Re-order line
        $order   = array("\r\n", "\n", "\r");   
        $replace = ' ';
        $content = str_replace($order, $replace, $content);
        $content = str_replace(". ", ".\r\n", $content);

        
        echo "<h3>".$name."</h3><br>";            
        $index = 0;
        
        $array_line = split("\r\n",$content);
        foreach($array_line as $line)
        {
          $index = $index + 1;
          $sentence = replace_new_line($line);
          if(empty($sentence) == true)
          {
            continue;
          }
          echo "<form id='form_". $index . "' action='' onsubmit=\"checkTyped(".$index.")\" target=\"hidden_frame\" onkeydown=\"onInputKeyDown(event,".$index.")\">";
          echo "<div id='div_". $index . "' onclick='onDivClick(this)'>". $sentence . "</div>";
          echo "<table style='width:100%'><tr>";
          echo "<td>";       
          echo "<input type='text' style='width:100%' id='typed' autocomplete='off' onblur='onBlurSubmit(".$index.")' onclick='onInputFocus(this,".$index.")' onfocus='onInputFocus(this,".$index.")'>";
          echo "</td>";
          echo "<td>";
          echo "<img src='./images/checked_16x16.png' style='display:none' id='img_checked_". $index . "' />";
          echo "</td>";
          echo "<td>";
          echo "<img src='./images/error_16x16.png' style='display:none' id='img_error_". $index . "' />";
          echo "</td>";
          echo "</tr></table>";
          echo "</form>";
        }
        echo "<iframe name='hidden_frame' id='hidden_frame' style='display:none'></iframe>";
      ?>
      <!--
      <div id="count">
        <script src="http://dict.cn/hc2/hc.js?v4" type="text/javascript"></script>
      </div>
      -->
  	</div>
    <div style="width:50px;height:100px;border:50px;padding:0px;margin:0px;overflow:hidden;float:left"></div>
  
    <div style="width:200px;border:50px;padding:0px;margin:0px;overflow:hidden">
    <?php include("setting.php"); ?>
    </div>
    
    <!-- Div for Selection -->
    <div id="div_select" style="position:absolute;display:none;background:#99D9EA;padding:1px 5px 2px;border:1px solid">
      <a href="#" onclick="onAddNewWord();return false" style="color:black">加入生词本</a>
      |                                                               
      <!-- return false means not to scroll to the top while clicked -->
      <a href="#" onclick="onDict();return false" style="color:black">查字典</a> 
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

















