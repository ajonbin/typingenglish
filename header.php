<script type="text/javascript">
function showLayer(id) 
{
    document.getElementById(id).style.display = "block";
}
function hideLayer(id) 
{
    document.getElementById(id).style.display = "none";
}
function subLoginForm()
{
  document.form_header_login.header_password.value = MD5(document.form_header_login.header_password.value);
  loginAjax();
}
function forgotPwd()
{
  if(checkEmail(document.form_header_login.header_username.value))
  {
    document.form_header_login.action = "./forgot_pwd.php";
    document.form_header_login.method = "POST";
    document.form_header_login.submit();
  }
  else
  {
    showText("span_header_login","用户名错误，请输入合法邮箱");
  }
}

function loginAjax()  
{     
  var url = "./function/login.php";
  var postStr = "username=" + document.form_header_login.header_username.value 
                + "&password=" + document.form_header_login.header_password.value
                + "&auto_login=" + document.form_header_login.header_auto_login.value;
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
                showText("span_header_login","登录失败，用户名或密码错误");  
              }
              else
              {
                document.getElementById("div_header").innerHTML= "<a href='index.php'>首页</a>|" +
                                                "<a href='#'>" + document.form_header_login.header_username.value + "</a> |" +
                                                "<a href='./function/logout.php'>注销</a> |" + 
                                                "<a href='./about.php'>关于TE</a>";
                hideLayer('lightBox');                                                
              }  
          }  
          else  
          {  
              showText("span_header_login","登录失败，请稍候重试");  
          }  
      }  
  }
  //定义传输的文件HTTP头信息
  xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //发送POST数据
  xmlHttp.send(postStr);  
}

</script>

<!--header begin-->
<div style="width:inherit;height:20px"></div>
<div class="body-header">
	<div id="div_header" style="float:right">
    <?php
      session_start();
      //if(array_key_exists('username',$_SESSION)){
      echo "<a href='./index.php'>首页</a> |";
      if(isset($_SESSION['username']) or (isset($_COOKIE['username']) and isset($_COOKIE['password'])))
      {
        if(isset($_COOKIE['username']) and isset($_COOKIE['password']))
        {
          $_SESSION['username'] = $_COOKIE['username'];
        }
        echo "<a href='#'>".$_SESSION['username']."</a> |";
        echo "<a href='./function/logout.php'>注销</a> |"; 
      }
      else
      {
        echo "<a href='#' onclick=\"showLayer('lightBox');return false;\">登录</a> |";
        echo "<a href='./page_register.php'>注册</a> |"; 
      }
      echo "<a href='./about.php'>关于TE</a>";
    ?>
  </div>
</div>
<div style="width:inherit;height:50px"></div>
<div>
  <center>
    <img src="./images/typing_48x48.png">
    <h1>Typing English</h1>
  </center>
</div>

<!-- login page -->
<div class="popupComponent" id="lightBox">
    <iframe class="popupIframe"></iframe>
    <div class="popupCover"></div>
    <div class="lightBox">
        <span class="lightBoxMaxHeight"></span>
        <div class="lightBoxContent">
            <form name="form_header_login">
              <table>
              <span id="span_header_login" style="display:none;color:red"></span>
              <tr>
                <td>用户名：</td>
                <td><input type="text" name="header_username" class="register-input"></td>
                <td><a href="./page_register.php">还没注册</a></td>
              </tr>
              <tr>
                <td>密码：</td>
                <td>
                  <input type="password" name="header_password" class="register-input">
                </td>
                <td><a href="#" onclick="forgotPwd();return false;">忘记密码</a></td>
              </tr>
              <tr>
                <td></td>
                <td>
                  <input type="checkbox" name="header_auto_login">自动登录
                  <input type="checkbox" name="header_save_username">记住用户名
                </td>
              </tr>
              <tr>
                <td><button onclick="subLoginForm();return false;" />确定</td>
                <td><button onclick="hideLayer('lightBox');return false;" />取消</td>
              </tr>
              </table>
            </form>
        </div>
    </div>
</div>
<!--header end-->
