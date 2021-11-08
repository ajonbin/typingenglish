<?php
  function Replace_Special_Char($str)
  {
    $str = str_replace("\\\"", "\"", $str);
    $str = str_replace("\\'", "'", $str); 
    return $str;
  }
?>