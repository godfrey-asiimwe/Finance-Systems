<?php
session_start();
// Change this to your connection info.

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Login &mdash; PT Finance</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->
<!--   <link rel="stylesheet" href="node_modules/bootstrap-social/bootstrap-social.css"> -->

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="d-flex flex-wrap align-items-stretch">
        <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
          <div class="p-4 m-3">
            <img src="assets/img/logo.png" alt="logo" width="80" class="shadow-light rounded-circle mb-5 mt-2">
            <h4 class="text-dark font-weight-normal">Welcome to <span class="font-weight-bold">PT Uganda</span></h4>
            <p class="text-muted">Before you get started, you must login or register if you don't already have an account.</p>

            <?php

              include 'DB.php';

                // Now we check if the data from the login form was submitted, isset() will check if the data exists.
              if(isset($_POST['submit'])){

                if ( !isset($_POST['username'], $_POST['password']) ) {
                  // Could not get the data that should have been sent.
                  exit('Please fill both the username and password fields!');
                }

                // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
                if ($stmt = $con->prepare('SELECT id, password FROM users WHERE username = ?')) {
                  // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
                  $stmt->bind_param('s', $_POST['username']);
                  $stmt->execute();
                  // Store the result so we can check if the account exists in the database.
                  $stmt->store_result();

                  if ($stmt->num_rows > 0) {
                  $stmt->bind_result($id, $password);
                  $stmt->fetch();
                  // Account exists, now we verify the password.
                  // Note: remember to use password_hash in your registration file to store the hashed passwords.
                  /*if (password_verify($_POST['password'], $password)) {*/
                     if ($_POST['password'] === $password) {
                    // Create sessions so we know the user is logged in, they basically act like cookies but remember the data on the server.
                    session_regenerate_id();
                    $_SESSION['loggedin'] = TRUE;
                    $_SESSION['username'] = $_POST['username'];
                    $_SESSION['id'] = $id;

                    if($_POST['username']=='admin'){
                      header('Location:index.php');
                    }
                  }else{
                    echo 'The user does not exit in the system';
                  }

                }

              }
            }
              /*$stmt->close();*/

             ?>
            <form method="POST" action="<?php echo $_SERVER['SCRIPT_NAME']?>" class="needs-validation" novalidate="">
              <div class="form-group">
                <label for="email">User Name</label>
                <input id="email" type="text" class="form-control" name="username" tabindex="1" required autofocus>
                <div class="invalid-feedback">
                  Please fill in your email
                </div>
              </div>

              <div class="form-group">
                <div class="d-block">
                  <label for="password" class="control-label">Password</label>
                </div>
                <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                <div class="invalid-feedback">
                  please fill in your password
                </div>
              </div>
<!-- 
              <div class="form-group">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                  <label class="custom-control-label" for="remember-me">Remember Me</label>
                </div>
              </div> -->

              <div class="form-group text-right">
              <!--   <a href="auth-forgot-password.html" class="float-left mt-3">
                  Forgot Password?
                </a> -->
                <button type="submit" name="submit" class="btn btn-primary btn-lg btn-icon icon-right" tabindex="4">
                  Login
                </button>
              </div>
            </form>

          </div>
        </div>
        <div class="col-lg-8 col-12 order-lg-2 order-1 min-vh-100 background-walk-y position-relative overlay-gradient-bottom" data-background="assets/img/finance3.png">
          <div class="absolute-bottom-left index-2">
            <div class="text-light p-5 pb-2">
              <div class="mb-5 pb-3">
                <!-- <h1 class="mb-2 display-4 font-weight-bold">Good Morning</h1> -->
                <script type="text/javascript">
			        document.write("<center><font size=+7 >");
			        var day = new Date();
			        var hr = day.getHours();
			        if (hr >= 0 && hr < 12) {
			            document.write("Good Morning!");
			        } else if (hr == 12) {
			            document.write("Good Noon!");
			        } else if (hr >= 12 && hr <= 17) {
			            document.write("Good Afternoon!");
			        } else {
			            document.write("Good Evening!");
			        }
			        document.write("</font></center>");
			    </script>
                <h5 class="font-weight-normal text-muted-transparent" style="color: red;">Gospel Worker</h5>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="assets/js/stisla.js"></script>

  <!-- JS Libraies -->

  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>

  <!-- Page Specific JS File -->
</body>
</html>
