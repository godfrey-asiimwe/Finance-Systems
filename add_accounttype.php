<?php
  include ('DB.php');
  require_once ("Class/DB.class.php");
  require_once ("Class/accountType.class.php");

  if (isset($_POST['name'])) {

        $name =$_POST['name'];
        $desc=$_POST['desc'];

        $time=time();
        $date2=date("Y-m-d",$time); 

        $no=uniqid();
        
        $accountType = new AccountType();
        $insertId = $accountType->addAccountType($date2,$no,$name,$desc);

    }
 ?>