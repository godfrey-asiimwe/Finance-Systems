 <?php
require_once ("Class/DB.class.php");
require_once ("Class/Account.class.php");
require_once ("Class/Deposit.class.php");
require_once ("Class/IncomeStatement.class.php");
require_once ("Class/FinancialYear.class.php");
require_once ("DB.php");


$account = new Account();
$financialYear=new FinancialYear();

  if (isset($_POST['amount'])) {

        $amount =$_POST['amount'];
        $acc=$_POST['account'];
       
        $des=$_POST['desc'];

        $year=$financialYear->getActiveFinancialYear($con);

        $time=time();
        $setup_date=date("Y-m-d",$time); 
        
        $deposit = new Deposit();
        $insertId = $deposit->addDeposit($setup_date,$acc,$amount,$des);

        $returnamount=new Account();
        $result=$returnamount->getAmountOnAccount($acc,$con);
     
        $amount2=$amount+$result;
        
        $accountUpdate=$returnamount->editAccountAmount($amount2,$acc);

        $category="Credit";
        $debit=0;

        $income=new IncomeStatement();
        $incomeStatement=$income->addIncomeStatement($setup_date,$category,$year,$acc,$des,$debit,$amount,$amount2);

    }
 ?>