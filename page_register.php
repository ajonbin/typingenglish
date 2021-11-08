<!doctype html>

<html>

<head>
<?php include("head.htm"); ?>
<title>Typing Enghils - Register</title>

<style type="text/css">
</style>

<script language="javascript" src="./js/md5.js"></script>
<script language="javascript" src="./js/util.js"></script>

<script type="text/javascript">

function hideSpanInfo()
{
  document.getElementById("span_username").style.display="none";
  document.getElementById("span_password").style.display="none";
  document.getElementById("span_confirm").style.display="none";
}

function Ajax()  
{     
  //xmlhttp.open("GET","user_ck.php?username="+document.getElementById("username").value,true);
  var url = "./function/register.php";
  var postStr = "username="+ document.form_reg.username.value +"&password="+ document.form_reg.password.value;
  xmlHttp.open("POST", url, true);

  //document.getElementById('username_notice').innerHTML = process_request;//显示状态  
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
                switch(parseInt(rs_json['error_code']))
                {
                case 1:
                  showText("span_username","用户名已注册");
                  break;
                case 2:
                  alert("服务器错误");
                }
              }
              else
              {
                window.location.replace("./index.php");
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
  hideSpanInfo();
  
  if (!checkEmail(ele_form.username.value))
  {
    showText("span_username","注册邮箱非法");
    ele_form.username.focus();
    return (false);
  }

  if (!checkPassword(ele_form.password.value))
  {
    showText("span_password","密码不合法，必须是字母、数字、!.-_@，长度必须大于6");
    ele_form.password.focus();
    return (false);
  }
  if (ele_form.confirm.value != ele_form.password.value)
  {
    showText("span_confirm","两次密码不一致!");
    ele_form.confirm.focus();
    return (false);
  }
  //Set MD5 for password
  document.form_reg.password.value = MD5(document.form_reg.password.value);
  document.form_reg.confirm.value = MD5(document.form_reg.confirm.value);
  
  Ajax();  
}


function submitRegForm()
{
  document.form_reg.password.value = MD5(document.form_reg.password.value);
  document.form_reg.confirm.value = MD5(document.form_reg.confirm.value);
  document.form_reg.submit();
  
}

  
</script>
</head>

<body >

<!--header-->
<?php include("header.php"); ?>

<!--main begin-->
<div class="body-main">
	<div class="brand-pic">
  	<div style="width:600px;height:600px;border:50px;padding:0px;margin:0px;overflow:visible;;float:left">
    <?php include("inner_list_articles.php"); ?>
  	</div>                       
    
    <div style="width:50px;height:100px;border:50px;padding:0px;margin:0px;overflow:hidden;float:left"></div>
    
    <div style="width:600px;border:50px;padding:0px;margin:0px;overflow:hidden;">
      <form name="form_reg">
        <table width="100%" border=0>
          <tr>
            <td width="20%">邮箱地址：</td>
            <td  width="60%">
              <input type="text" name="username" class="register-input" />
              <span id="span_username" style="display:none;color:red">*</span>
            </td>
          </tr>
          <tr>
            <td>登录密码：</td>
            <td>
              <input type="password" name="password" class="register-input"/>
              <span id="span_password" style="display:none;color:red">*</span>
            </td>
          </tr>
          <tr>
            <td>确认密码：</td>
            <td>
              <input type="password" name="confirm" class="register-input"/>
              <span id="span_confirm" style="display:none;color:red">*</span>
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