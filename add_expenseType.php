 <?php

include ('DB.php');
require_once ("Class/DB.class.php");
require_once ("Class/ExpenseType.class.php");

  if (isset($_POST['name'])) {

        $name = $_POST['name'];
        $desc=$_POST['desc'];

        $time=time();
        $date2=date("Y-m-d",$time); 
        
        $expenseType = new ExpenseType();
        $insertId = $expenseType->addExpenseType($date2,$name,$desc);

    }
 ?>