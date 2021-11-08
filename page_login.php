<!doctype html>

<html>

<head>
<?php include("head.htm"); ?>
<title>Typing Enghils - Login </title>

<style type="text/css">
</style>

<script language="javascript" src="./js/md5.js"></script>
<script language="javascript" src="./js/util.js"></script>

<script type="text/javascript">

function hideSpanInfo()
{
  document.getElementById("span_page_login_username").style.display="none";
  document.getElementById("span_page_login_password").style.display="none";
  document.getElementById("span_page_login_info").style.display="none";
}

function pageLoginAjax()  
{     
  var url = "./function/login.php";
  var postStr = "username=" + document.form_page_login.username.value 
                + "&password=" + document.form_page_login.password.value
                + "&auto_login=" + document.form_page_login.auto_login.value;
  xmlHttp.open("POST", url, true);

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
                showText("span_page_login_info","登录失败，用户名或密码错误");  
              }
              else
              {
                showText("span_page_login_info","登录成功,正在跳转页面");
                setTimeout("history.go(-1)",1500);
              }  
          }  
          else  
          {  
              showText("span_page_login_info","登录失败，请稍候重试");  
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
  var ele_form = document.form_page_login;
  hideSpanInfo();
  
  if (!checkEmail(ele_form.username.value))
  {
    showText("span_page_login_username","注册邮箱非法");
    ele_form.username.focus();
    return (false);
  }

  if (!checkPassword(ele_form.password.value))
  {
    showText("span_page_login_password","密码不合法，必须是字母、数字、!.-_@，长度必须大于6");
    ele_form.password.focus();
    return (false);
  }
  //Set MD5 for password
  document.form_page_login.password.value = MD5(document.form_page_login.password.value);
   
  pageLoginAjax();  
}


function submitRegForm()
{
  document.form_page_login.password.value = MD5(document.form_page_login.password.value);
  document.form_page_login.submit();
}

  
</script>
</head>

<body >

<!--header-->
<?php include("header.php"); ?>

<!--main begin-->
<div class="body-main">
  <h1><center>Typing English</center></h1>
	<div class="brand-pic">
  	<div style="width:600px;height:600px;border:50px;padding:0px;margin:0px;overflow:visible;;float:left">
    <?php include("inner_list_articles.php"); ?>
  	</div>                       
    
    <div style="width:50px;height:100px;border:50px;padding:0px;margin:0px;overflow:hidden;float:left"></div>
    
    <div style="width:600px;border:50px;padding:0px;margin:0px;overflow:hidden;">
      <form name="form_page_login">
        <span id="span_page_login_info" style="display:none;color:red"></span>
        <table width="100%" border=0>
          <tr>
            <td width="20%">邮箱地址：</td>
            <td  width="60%">
              <input type="text" name="username" class="register-input" />
              <span id="span_page_login_username" style="display:none;color:red">*</span>
            </td>
          </tr>
          <tr>
            <td>登录密码：</td>
            <td>
              <input type="password" name="password" class="register-input"/>
              <span id="span_page_login_password" style="display:none;color:red">*</span>
            </td>
          </tr>
          <tr>
            <td></td>
            <td>
              <input type="checkbox" name="auto_login">自动登录
              <input type="checkbox" name="save_username">记住用户名
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
  	</div>

  </div>
</div>

<!--main end-->

<!--footer-->
<?php include("footer.php"); ?>

</body>
</html>