<?php

include ('DB.php');
require_once ("Class/DB.class.php");
require_once ("Class/FinancialYear.class.php");

if (isset($_POST['name'])) {

  $name =$_POST['name'];
  $desc=$_POST['desc'];

  $time=time();
  $date2=date("Y-m-d",$time); 
  
  $financialYear = new FinancialYear();
  $insertId = $financialYear->addFinancialYear($date2,$name,$desc);


}
?>