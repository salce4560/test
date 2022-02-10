<?php
include_once "../base.php";
 $views=$_POST['bottom'];
 echo $views;
 $cottom=$Bottom->find(1);
 echo "<pre>";
 print_r($cottom);
 echo "</pre>";
 $cottom['bottom']=$views;
 echo '$cottom[bottom]'.$cottom['bottom'];
 $cottom=$Bottom->save($cottom);
// $Bottom->save(['id'=>1,'bottom'=>$_POST['bottom']]);

to("../back.php?do=bottom");



?>