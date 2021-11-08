function checkEmail(email_str) 
{
  var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{1,})+$/;
  return filter.test(email_str);
}

function checkPassword(pwd_str)
{
  var filter = /^([a-zA-Z0-9!.\-_@]{6,})$/;
  return filter.test(pwd_str);
}


function showText(target,Info)  
{  
  document.getElementById(target).style.display = "block";
  document.getElementById(target).innerHTML = Info;  
}



// Ajax
/* Create a new XMLHttpRequest object to talk to the Web server */  
var xmlHttp = false;  
/*@cc_on @*/  
/*@if (@_jscript_version >= 5) 
try { 
  xmlHttp = new ActiveXObject("Msxml2.XMLHTTP"); 
} catch (e) { 
  try { 
    xmlHttp = new ActiveXObject("Microsoft.XMLHTTP"); 
  } catch (e2) { 
    xmlHttp = false; 
  } 
} 
@end @*/  
if (!xmlHttp && typeof XMLHttpRequest != 'undefined') {  
  xmlHttp = new XMLHttpRequest();  
}


/*********** Navigator Version *********************/
function getNavigatorVersion()
{
  if(navigator.userAgent.indexOf("MSIE")>0) {  
    return "MSIE";  
  }  
  if(isFirefox=navigator.userAgent.indexOf("Firefox")>0){  
    return "Firefox";  
  }  
  if(isSafari=navigator.userAgent.indexOf("Safari")>0) {  
    return "Safari";  
  }   
  if(isSafari=navigator.userAgent.indexOf("Chrome")>0) {  
    return "Chrome";  
  }
  return "Other"; 
}

function getMousePosX()
{
  return window.event.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
}

function getMousePosY()
{
  return window.event.clientY + document.body.scrollTop + document.documentElement.scrollTop;
}

function getSelectedText()
{
  return document.all ? 
                  document.selection.createRange().text : 
                  document.getSelection().toString();

}

function isEleDisplay(element)
{
  if(element.style.display == "block")
  {
    return true;
  }
  else
  {
    return false;
  }
}

function isMouseInDiv(ele_div)
{
  if(ele_div.contains(window.event.srcElement))
  {
    return true;
  }
  else
  {
    return false;
  }
}

function gotoLink(link)
{
  self.location = link;
}