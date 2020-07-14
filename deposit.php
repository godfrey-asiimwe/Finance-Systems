<?php 
require_once ("Class/DB.class.php");
require_once ("Class/Account.class.php");
require_once ("Class/Deposit.class.php");
require_once ("Class/IncomeStatement.class.php");
require_once ("Class/FinancialYear.class.php");
require_once ("DB.php");


$account = new Account();
$financialYear=new FinancialYear();
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

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="../node_modules/jqvmap/dist/jqvmap.min.css">
  <link rel="stylesheet" href="../node_modules/summernote/dist/summernote-bs4.css">
  <link rel="stylesheet" href="assets/owl.carousel.min.css">
  <link rel="stylesheet" href="assets/owl.theme.default.min.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">

  <script>
    function myFunction() {
      var x = document.getElementById("deposit");
      if (x.style.display === "none") {
        
        x.style.display = "block";
      } else {
        x.style.display = "none";
      }
    }
  </script>


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
            <a href="index.php">PT Finance</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.php">PTF</a>
          </div>
           <ul class="sidebar-menu">
              <li class="menu-header" style="font-weight: bold !important; ">Dashboard</li>
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
          <div class="row">
            
          </div><br><br><br>

          <div class="section-body" >
            <h2 class="section-title">Deposits</h2>
            <p class="section-lead">We provide advanced input fields, such as date picker, color picker, and so on.</p>

          </div>

            <div class="row">
              <div class="col-lg-12 col-md-12 col-12 col-sm-12">
              <div class="card">
                <div class="card-header">
                  <h4>List of Deposits</h4>
                  <div class="card-header-action">
                    <button   data-toggle="modal" data-target="#logoutModal" class="dropdown-item has-icon text-danger btn btn-primary" style="color: white !important;" class="btn btn-primary">Make a Deposit</button>
                  </div>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive" id="result">
                    <table id="example" class="table table-striped table-bordered mb-0" style="width:100%; padding:10px !important;">
                      <thead>
                        <tr>
                          <th>Date of Creation</th>
                          <th>Amount</th>
                          <th>Account</th>
                          <th>Description</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $deposit2 = new Deposit();
                        $result = $deposit2->getAllDeposits();

                       if (! empty($result)) {
                        foreach ($result as $k => $v) {
                        ?>

                        <tr>
                          <td>
                            <?php echo $result[$k]["setup_date"]; ?>
                          </td>
                          <td style="font-weight: bold;"> Ugx
                            <?php echo number_format($result[$k]["amount"]); ?>
                          </td>
                          <td>
                            <?php $id=$result[$k]["account"]; $resultAccount = $account->getSpecificAccount($id,$con);  ?>
                          </td>
                          <td>
                            <?php echo $result[$k]["des"]; ?>
                          </td>
                          <td>
                            <a class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit" href="index.php?action=student-edit&id=<?php echo $result[$k]["id"]; ?>"><i class="fas fa-pencil-alt"></i></a>
                            <a href="index.php?action=student-edit&id=<?php echo $result[$k]["id"]; ?>" class="btn btn-danger btn-action" data-toggle="tooltip" title="Delete"  data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="alert('Deleted')"><i class="fas fa-trash"></i></a>
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

       <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Make A Deposit</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-body">

                     <form id="deposit">
                         <div class="form-group col-md-8 col-lg-8">
                          <label>Select Account</label>
                          <select class="form-control" id="account" name="account">
                            <?php $account->getAllAccountForSelection(); ?>
                          </select>
                        </div>
                        <div class="form-group col-md-8 col-lg-8">
                          <label>Amount</label>
                          <input type="number" id="amount" name="amount" class="form-control">
                        </div>
                        <div class="form-group col-md-8 col-lg-8">
                          <label>Description</label>
                          <textarea name="desc" id="desc" class="form-control"></textarea>
                        </div>
                         <button type="button" style="color: white;" id="add_deposit"   class="btn btn-primary daterange-btn icon-left btn-icon"><i class="fas fa-calendar"></i> Save
                          </button> 
                    </form>
            </div>
            </div>
          </div>
        </div>

      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2020 <div class="bullet"></div> Design By Godfrey Asiimwe</a>
        </div>
        <div class="footer-right">
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

 <script type = "text/javascript">
  $(document).ready(function(){
     //displayResult();
  /*  ADDING POST */  
    
    $('#add_deposit').on('click', function(){

      if($('#amount').val() == ""){
        alert('Please enter amount');
      }else{
        
        $amount =$('#amount').val();
        $account =$('#account').val();
        $desc= $('#desc').val();
        
        $.ajax({
          type: "POST",
          url: "add_deposit.php",
          data: {
            amount:$amount,
            account:$account,
            desc:$desc,
            
          },
          success: function(){

            $("#deposit")[0].reset();

            $("#result").load(" #result");
            
            //displayResult();
          }
        });
      } 
    });

  /*****  *****/

  });
  
  function displayResult(){

    $.ajax({
      url: 'add_deposit.php',
      type: 'POST',
      async: false,
      data:{
        res: 1
      },
      success: function(response){
        $('#result').html(response);
      }
    });

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