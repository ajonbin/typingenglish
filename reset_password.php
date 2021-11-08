<!doctype html>

<html>

<head>
<title>Typing Enghils - Forgot Password</title>
<?php include("head.htm"); ?>

<style type="text/css">
</style>

<script language="javascript" src="./js/md5.js"></script>
<script language="javascript" src="./js/util.js"></script>
<script type="text/javascript">

function hideSpanInfo()
{
  document.getElementById("span_reset").style.display="none";
  document.getElementById("span_password").style.display="none";
  document.getElementById("span_new_password").style.display="none";
  document.getElementById("span_new_confirm").style.display="none";
}

function Ajax()  
{     
  var url = "./function/reset_pwd.php";

  var postStr = "username=" + document.form_reg.username.value + 
                "&password="+ document.form_reg.password.value +
                "&new_password=" + document.form_reg.new_password.value +
                "&new_confirm=" + document.form_reg.new_confirm.value;

  xmlHttp.open("POST", url, true);
   
  xmlHttp.onreadystatechange=function()  
  {  
      if (4==xmlHttp.readyState)  
      {  
          hideSpanInfo();
          if (200==xmlHttp.status)  
          {  
              var responseText = xmlHttp.responseText;
              var rs_json = eval('('+ responseText +')');
              if(rs_json['success'] == 'false')
              {
                switch(parseInt(rs_json['error_code']))
                {
                case 1:
                  showText("span_reset",rs_json['error_msg']);
                  break;
                case 2:
                  alert("服务器错误");
                }
              }
              else
              {
                showText("span_reset","密码修改成功");
                document.form_reg.reset();
              }
          }  
          else  
          {  
              alert("发生错误!");  
          }
            
      }  
  }
  //定义传输的文件HTTP头信息
  xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //发送POST数据
  xmlHttp.send(postStr);   
}  

function inputCheck()
{
  var ele_form = document.form_reg;
  if (!checkPassword(ele_form.password.value))
  {
    showText("span_password","密码不合法，必须是字母、数字、!.-_@，长度必须大于6");
    ele_form.password.focus();
    return (false);
  }
  
  if (!checkPassword(ele_form.new_password.value))
  {
    showText("span_new_password","密码不合法，必须是字母、数字、!.-_@，长度必须大于6");
    ele_form.new_password.focus();
    return (false);
  }
  if (ele_form.new_confirm.value != ele_form.new_password.value)
  {
    showText("span_new_confirm","两次密码不一致!");
    ele_form.new_confirm.focus();
    return (false);
  }

  //Set MD5 for password
  if(!document.form_reg.password.getAttribute('disabled'))
  {
    document.form_reg.password.value = MD5(document.form_reg.password.value);
  }
  document.form_reg.new_password.value = MD5(document.form_reg.new_password.value);
  document.form_reg.new_confirm.value = MD5(document.form_reg.new_confirm.value);
  
  Ajax(); 
}


</script>
</head>

<body >
<?php include("header.php"); ?>

<!--main begin-->
<div class="body-main">
	<div class="brand-pic">
  	<div style="width:600px;height:600px;border:50px;padding:0px;margin:0px;overflow:visible;;float:left">
    <?php include("inner_list_articles.php"); ?>
  	</div>                       
    
    <div style="width:50px;height:100px;border:50px;padding:0px;margin:0px;overflow:hidden;float:left"></div>
    
    <div style="width:600px;border:50px;padding:0px;margin:0px;overflow:hidden;">
      <?php
        error_reporting(E_ALL ^ E_WARNING);
        $REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];
      	//echo $REQUEST_METHOD;
      	if($REQUEST_METHOD == 'GET'){
          if(isset($_GET['p']))
          {
            //from email reset
            require_once ('./function/connect_db.php');
          
            $string=$_GET['p'];
            $array = explode('+',base64_decode($string));
            $sql = "select password from user where name = '".trim($array['0'])."'";  
            //echo $sql;  
            $query=mysql_query($sql,$conn);  
            $rs=mysql_fetch_array($query);  
            $password = $rs['password'];
            if($password == $array[1])
            {
              if(time() <= $array[2])
              {
                echo "<form name='form_reg' action='./function/reset_pwd.php' method='post'>";
                echo "<table>";
                echo "<span id='span_reset' style='display:none;color:red'>span</span>";
                echo "<tr>";
                echo "<td>用户名：</td>";
                echo "<td><input type='text' name='username' class='register-input' value='".$array[0]."' disabled='true'></td>";
                echo "</tr>"; 
                echo "<tr>";
                echo "<td>登录密码：</td>";
                echo "<td>";
                echo "<input type='password' name='password' class='register-input' value='".$array[1]."' disabled='true'>";
                echo "<span id='span_password' style='display:none;color:red'></span>";
                echo "</td></tr>";
              }
              else
              {
                echo "无效链接<br>";
                exit();
              }
            }
            else
            {
              echo "无效链接<br>";
              exit();
            }
          }
          else
          {
            if(isset($_SESSION['username']))
            {
              echo "<form name='form_reg'>";
              echo "<table>";
              echo "<span id='span_reset' style='display:none;color:red'>span</span>";
              echo "<tr>";
              echo "<td>用户名：</td>";
              echo "<td><input type='text' name='username' class='register-input' value='".$_SESSION['username']."' disabled></td>";
              echo "</tr>";  
              echo <<< EOT
<tr>
<td>登录密码：</td>
<td>
<input type="password" name="password" class="register-input" />
<span id="span_password" style="display:none;color:red"></span>
</td>
</tr>        
EOT;
            }
            else
            {
              header("Location: ./page_login.php");
              exit();
            }
          }
      	}else if($REQUEST_METHOD == 'POST'){
          exit();
        }
        
        echo <<< EOT
<tr>
<td>重设密码：</td>
<td>
<input type="password" name="new_password" class="register-input"/>
<span id="span_new_password" style="display:none;color:red"></span>
</td>
</tr>
<tr>
<td>确认密码：</td>
<td>
<input type="password" name="new_confirm" class="register-input"/>
<span id="span_new_confirm" style="display:none;color:red"></span>
</td>
</tr>
<tr>
<td>
<button onclick="inputCheck();return false;">提交</button>
</td>
<td>
<button onclick="form.reset();return false;">清空</button>
</td>
</tr>
</table>
</form>          
EOT;
        
      ?>
    
      
  	</div>

  </div>
</div>

<!--main end-->

<!--footer-->
<?php include("footer.php"); ?>

</body>
</html>