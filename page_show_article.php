<!doctype html>

<html>

<head>
<title>Typing Enghils - Typing</title>
<?php include("head.htm"); ?>

<style type="text/css">
</style>
<script language="javascript" src="./js/md5.js"></script>
<script language="javascript" src="./js/util.js"></script>
<script language="javascript">

  /*********** Dict & New Word *************/
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
  
  
  /*************** Annotation ***************/
  function annotationAjax()  
  {     
    var aid = document.getElementById("input_aid").value;
    var annotation = document.getElementById("input_annotation").value;
    var url = "./function/add_annotation.php";
    var postStr = "file=" + aid + "&annotation=" + annotation;

    xmlHttp.open("POST", url, true);
    
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
                  //Add slash for json parse
                  var escaped_js_annotaion = rs_json['annotation'].replace(/'/g,"\\'").replace(/\n/g,"\\n").replace(/\r/g,"\\r").replace(/\\/g,"\\\\");
                  //alert(escaped_js_annotaion);
                  var array_annotation = eval(escaped_js_annotaion);
                  var innerHtml = "全部注释<br>";
                  for (var item in array_annotation)
                  {
                      //innerHtml += "<div style='width:95%;background:#F0F9FE'>" + array_annotation[item]['user'] + "</div>";
                      //alert(array_annotation[item]['annotation']);
                      var html_annotation =  array_annotation[item]['annotation'].replace(/\\r\\n/g,"<br>");
                      html_annotation =  html_annotation.replace(/\\n/g,"<br>");
                      html_annotation =  html_annotation.replace(/\\r/g,"<br>");
                      html_annotation =  html_annotation.replace(/\\'/g,"'");
                      innerHtml += "<div style='width:95%;background:#F0F9FE'>" + html_annotation + "</div><br>";
                      
                      //alert(array_annotation[item]['user']);
                      //alert(array_annotation[item]['date']);
                      //alert(array_annotation[item]['annotation']);
                  }
                  document.getElementById("div_annotation").innerHTML=innerHtml;
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
    xmlHttp.send(postStr);  
    
    //清空数据
    document.getElementById("form_annotation").reset();
  }
  
  
  function onMyAnnotation()
  {
    annotationAjax();  
  }
  
  function onTyping(aid)
  {
    gotoLink("./typing.php?file=" + aid);
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
      <!--Content-->
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
        $get_query = mysql_query("select title,content,annotation from articles WHERE aid='$aid'");
        $row = mysql_fetch_array($get_query);
        mysql_free_result($get_query);
        
        //Get New words list
        $new_words = array();
        if(isset($_SESSION['username']))
        {
          $username = $_SESSION['username'];
          $get_query = mysql_query("select * from new_words where user='$username' limit 1");
          $result = mysql_fetch_array($get_query);
          if($result)
          {
            $new_words = (array)json_decode($result['new_words']);
            
            mysql_free_result($result);  
          }
        }

      
        //Show Content
        $name = $row['title'];
        //$name = Replace_Special_Char($name);
        $content = $row['content'];
        $annotation = $row['annotation'];
        
        echo "<h3>".$name."</h3><br>";
        
        //Look fro new_word, if match highlight it.
        if(!empty($new_words))
        {
          foreach($new_words as $word=>$v)
          {
            $to_replace = " ".$word." ";
            $highlight = "&nbsp<span style='background:yellow'>". $word . "</span>&nbsp";
            $content=str_replace($to_replace, $highlight, $content);
          }
        }
          
          
        $array_line = split("\r\n",$content);
        foreach($array_line as $line)
        {
          echo $line . "<br>";
        }
        //echo "<iframe name='hidden_frame' id='hidden_frame' style='display:none'></iframe>";
        
        //Typing
        echo "<br>";
        echo "<center><button onclick='onTyping($aid);return false;'>Type it</button></center>";
        
        //Annotation
        echo "<br>";
        echo "<div id='div_annotation' name='div_annotation'>";
        echo "全部注释<br>";
        $get_query = mysql_query("select annotation from articles where aid='$aid' limit 1");
        $result = mysql_fetch_array($get_query);
        $array_annotation = array();
        if($result)
        {
          //echo $result['annotation']; 
          $escaped_annotation = str_replace(PHP_EOL,"<br>",$result['annotation']);
          $array_annotation = (array)json_decode($escaped_annotation);
          echo "<br>";
          //print_r($array_annotation);
          foreach($array_annotation as $annotation_item)
          {
            $array_item = (array)$annotation_item;
            //echo "<div style='width:95%;background:#F0F9FE'>";
            //echo $array_item['user'];
            //echo "</div>";         
            echo "<div style='width:95%;background:#F0F9FE'>";
            echo $array_item['annotation'];
            echo "</div><br>";   
          }
          mysql_free_result($get_query);
        }
        echo "</div>";
        
        mysql_close();
      ?>
      
      <!--Annotation-->
      <br>
      <div style="width:95%;background:#F0F9FE">我的注释</div>
      <br>
      <div style="width:100%">
        <form id="form_annotation" name="form_annotation" method="post">
          <?php echo "<input name='input_aid' id='input_aid' type='hidden' value='$aid'>"; ?>
          <textarea name="input_annotation" id="input_annotation" style="overflow:auto;width:95%;height:100px"></textarea>
          <center>
          <button onclick="onMyAnnotation();return false;">提交注释</button>
          <button onclick="form.reset();return false;">清空</button>
          </center>
        </form>
        <br>
      </div>
      
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

















