<?php 

// We need to use sessions, so you should always start sessions using the below code.
session_start();

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
  header('Location:login.php');
  exit;
}

require_once ("Class/DB.class.php");
require_once ("Class/IncomeStatement.class.php");
require_once ("DB.php");
require_once ("Class/Account.class.php");
require_once ("Class/FinancialYear.class.php");


$check=mysqli_query($con,"SELECT username FROM users") or die(mysqli_error());
if(mysqli_num_rows($check)==0){
    $username='admin';
    $password=sha1('Pass=123');
    @mysqli_query($con,"INSERT INTO users(username,password) VALUES('$username','$password')") OR die(mysqli_error());
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>PT Finance &mdash; </title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="../node_modules/jqvmap/dist/jqvmap.min.css">
  <link rel="stylesheet" href="../node_modules/summernote/dist/summernote-bs4.css">
  <link rel="stylesheet" href="assets/owl.carousel.min.css">
  <link rel="stylesheet" href="assets/owl.theme.default.min.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
<!--   <link rel="stylesheet" href="assets/css/bootstrap.css"> -->
   <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="assets/css/components.css">

  

</head>

<body>
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
          </ul>
        </form>
      </nav>
      <div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="index.php"><img src="assets/img/logo.png" style="width: 70px;margin-top: 20px;margin-bottom: 20px;margin-left: -50px;"></a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.php">PTF</a>
          </div>
          <ul class="sidebar-menu" style="margin-top: 20px;">
              <li class="menu-header" style="font-weight: bold !important; "></li>
                    <li><a class="nav-link" href="index.php"><i class="fas fa-bars"></i> <span>Dashboard</span></a></li>
                      <li><a class="nav-link" href="financialYear.php"><i class="fas fa-bars"></i> <span>Financial Year</span></a></li>
              <li class="menu-header" style="font-weight: bold;">Accounts</li>
                    <li><a class="nav-link" href="organisation.php"><i class="far fa-user"></i> <span>Organisation</span></a></li>
                    <li><a class="nav-link" href="accountType.php"><i class="fas fa-bars"></i> <span>Account Type</span></a></li>
                    <li><a class="nav-link" href="account.php"><i class="far fa-user"></i> <span>Account</span></a></li>
              <li class="menu-header" style="font-weight: bold;">Deposits</li>
                    <li><a class="nav-link" href="deposit.php"><i class="fas fa-dollar-sign"></i> <span>Deposit</span></a></li>
              <li class="menu-header" style="font-weight: bold;">Expenses</li>
                    <li><a class="nav-link" href="expenseType.php"><i class="fas fa-bars"></i> <span>Expense Category</span></a></li>
                    <li><a class="nav-link" href="expense.php"><i class="fas fa-dollar-sign"></i> <span>Expense</span></a></li>
            </ul>
        </aside>
      </div>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
            <h2 class="section-title">Reports</h2>
            <p class="section-lead">We provide advanced input fields, such as date picker, color picker, and so on.</p>

          <div class="row">
              <div class="col-lg-12 col-md-12 col-12 col-sm-12">
              <div class="card">
                <div class="card-header">
                  <h4>Income Statement</h4>
                  <div class="card-header-action">
                    <a onclick="exportTableToExcel('example', 'IncomeStatement')" style="color: white !important" class="btn btn-primary">Export Table Data To Excel File</a>
                  </div>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive">
                   
                    <table  id="example" class="table table-striped table-bordered mb-0" style="width:100%; padding: 50px !important;">
                      <thead>
                        <tr>
                          <th>Date </th>
                          <th>Fin. Year </th>
                          <th>Description</th>
                          <th>Account</th>
                          <th>Debit (Ugx)</th>
                          <th>Credit (Ugx)</th>
                          <th>Balance (Ugx)</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php

                        $IncomeStatement = new IncomeStatement();
                        $result = $IncomeStatement->getIncomeStatement();

                        $account = new Account();

                        $financialYear=new FinancialYear();

                      if (! empty($result)) {
                        foreach ($result as $k => $v) {
                        ?>
                        <tr id="category">
                          <td>
                            <?php echo $result[$k]["setup_date"]; ?>
                          </td>
                           <td>
                            <?php $id=$result[$k]["finacialYear"]; $year = $financialYear->getSpecificfinancialYear($id,$con);  ?>
                          </td>
                           <td>
                            <?php echo $result[$k]["name"];  ?>
                          </td>
                           <td>
                            <?php $id=$result[$k]["account"]; $resultAccount = $account->getSpecificAccount($id,$con);  ?>
                          </td>
                          <td style="font-weight: bolder;">
                            <?php echo number_format($result[$k]["debit"]); ?>
                          </td>
                          <td style="font-weight: bolder;">
                            <?php echo number_format($result[$k]["credit"]); ?>
                          </td>
                          <td style="font-weight: bolder;">
                            <?php echo number_format($result[$k]["balance"]); ?>
                          </td>
                        </tr>
                        
                    <?php
                        }
                    }
                    ?>
                      </tbody>
                      
                    </table>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
      <footer class="main-footer">
        <div class="footer-left footer-color">
          Copyright &copy; 2020 <div class="bullet"></div> Design By Godfrey Asiimwe</a>
        </div>
        <div class="footer-right footer-color">
          Vr 1.0
        </div>
      </footer>
    </div>
  </div>

  <!-- General JS Scripts -->
 <!--  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script> -->
  <script src="assets/js/jquery-3.5.1.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="assets/js/stisla.js"></script>

  <script type="text/javascript">
    
    $(document).ready(function() {

        $('#example').DataTable();

      } );
  </script>
  <script>  
 $(document).ready(function(){  
      $('#create_excel').click(function(){  
           var excel_data = $('#example').html();  
           var page = "excel.php?data=" + excel_data;  
           window.location = page;  
      });  
 });  
 </script> 

 <script type="text/javascript">
   function exportTableToExcel(example, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(example);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}
 </script>

  <!-- JS Libraies -->
  <script src="node_modules/jquery-sparkline/jquery.sparkline.min.js"></script>
  <script src="node_modules/chart.js/dist/Chart.min.js"></script>
  <script src="node_modules/owl.carousel/dist/owl.carousel.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/chocolat/1.0.1/js/chocolat.min.js" integrity="sha256-+NOBtGTwk1dGgV+C4AY7c57MNivcv8LVxoZ8ge1uO3Y=" crossorigin="anonymous"></script>

  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
  <script src="assets/js/jquery.dataTables.min.js"></script>
  <script src="assets/js/dataTables.bootstrap4.min.js"></script>

  <!-- Page Specific JS File -->
  <script src="assets/js/page/index.js"></script>
</body>
</html>
