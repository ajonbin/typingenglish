<?php
$array_a = array("a1"=>"a1v","a2"=>"a2v");
$array_b = array("b1"=>"b1v","b2"=>"b2v");

$js_a = json_encode($array_a);
$js_b = json_encode($array_b);

$array_t = array();
$array_t[0] = $array_a;
$array_t[1] = $array_b;

print_r($array_t);

echo "<br>";

$js_t = json_encode($array_t);

print_r(json_decode($js_t));
echo "<br>";
print_r($js_t);

?>