 <?php
 
require_once ("Class/DB.class.php");
require_once ("Class/Expense.class.php");
require_once ("Class/ExpenseType.class.php");
require_once ("Class/Account.class.php");
require_once ("Class/IncomeStatement.class.php");
require_once ("Class/FinancialYear.class.php");

require_once ("DB.php");


  $account = new Account();
  $expenseType = new ExpenseType();
  $financialYear=new FinancialYear();
  
 
  if (isset($_POST['amount'])) {

        $amount = $_POST['amount'];
        $exp_type=$_POST['expenseType'];
        $acc=$_POST['account'];
        $desc=$_POST['desc'];

       
        $year=$financialYear->getActiveFinancialYear($con);


        $time=time();
        $setup_date=date("Y-m-d",$time); 
        
        

        $returnamount=new Account();
        $result=$returnamount->getAmountOnAccount($acc,$con);

        $amount2=$result-$amount;

        if($amount2<0){
        ?>

          <script>
            alert("You dont have enough money on this account");

          </script>

        <?php

        }else{

        $expense = new Expense();
        $insertId = $expense->addExpense($setup_date,$exp_type,$acc,$amount,$desc);
        
        $accountUpdate=$returnamount->editAccountAmount($amount2,$acc);

        $category="Debit";
        $credit=0;

        $income=new IncomeStatement();
        $incomeStatement=$income->addIncomeStatement($setup_date,$category,$year,$acc,$desc,$amount,$credit,$amount2);

        }


    }
 ?>