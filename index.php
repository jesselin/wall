<?php
  session_start();
  require("connection.php");
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" content="">
    <title>Wallify - Login / Create Account</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="js/bootstrap-tab.js"></script>
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/ui-lightness/jquery-ui.css" type="text/css" media="all" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link href="css/style.css" type="text/css" rel="stylesheet">  
    <script type="text/javascript">
      $(document).ready(function(){
        
      });  //on document ready, do these jquery things
    </script>
  </head>
  <body>
    <div id="topdiv">
      <div class="wrapper">
        <div id="logo">
          <h1>Wallify</h1>
        </div>
      </div>
    </div>
    <div id="logincontainer">
      <div class="" id="loginModal">
        <div class="modal-header">
          <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> -->
          <h3>Login / Create Account</h3>
        </div>
        <div class="modal-body">
          <div class="well">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#login" data-toggle="tab">Login</a></li>
              <li class="active"><a href="#create" data-toggle="tab">Create Account</a></li>
              <!-- <li><a href="#create" data-toggle="tab">Create Account</a></li> -->
            </ul>
            <div id="myTabContent" class="tab-content">
              <div class="tab-pane active in" id="login">
                  
                <!-- LOGIN -->

                <form class="form-horizontal" action='process.php' method="POST">
                  <fieldset>
                    <div id="legend">
                      <legend class=""></legend>
                    </div>    
                    <h4>Login</h4>
                    <?php 
                      if(isset($_SESSION['create_account_success']))
                      {
                        echo $_SESSION['create_account_success'];   
                      }
                      unset($_SESSION['create_account_success']);          
                    ?>
                 
                    <div class="control-group">
                      <!-- Username -->
                      <label class="control-label"  for="login_email">Email</label>
                      <div class="controls">
                        <input type="text" id="login_email" name="login_email" placeholder="" class="input-xlarge">
                      </div>
                    </div>
                    <input type="hidden" name="action" value="login" />
                    <div class="control-group">
                      <!-- Password-->
                      <label class="control-label" for="login_password">Password</label>
                      <div class="controls">
                        <input type="password" id="login_password" name="login_password" placeholder="" class="input-xlarge">
                      </div>
                      <?php 
                      if(isset($_SESSION['login_fail']))
                      {
                        echo $_SESSION['login_fail'];   
                      }
                      unset($_SESSION['login_fail']);          
                      ?>
                    </div>

                    <div class="control-group">
                      <!-- Button -->
                      <div class="controls">
                      <input type="submit" value="Login" class="btn btn-info">
                        <!-- <button class="btn btn-primary">Login</button> -->
                      </div>
                    </div>
                  </fieldset>
                </form>                
              </div>

              <!-- CREATE ACCOUNT -->

              <div class="tab-pane active" id="create">
              <!-- <div class="tab-pane fade" id="create"> -->
                <form id="tab" class="form-horizontal" action='process.php' method="POST">
                  <br>
                  <h4>Create Account</h4>

                  <?php 
                    if(isset($_SESSION['error_duplicate_account']))
                    {
                      echo $_SESSION['error_duplicate_account'];   
                    }
                    unset($_SESSION['error_duplicate_account']);          
                  ?>
                  <div class="control-group">
                    <!-- First Name -->
                    <label class="control-label" for="first_name">First Name</label>
                    <div class="controls">
                      <input type="text" id="first_name" name="first_name" placeholder="" class="input-xlarge">
                      <p class="help-block">Please provide your first name</p>
                    </div>
                  </div>
                  <?php 
                    if(isset($_SESSION['error_first_name']))
                    {
                      echo $_SESSION['error_first_name'];   
                    }
                    unset($_SESSION['error_first_name']);          
                  ?>
                  <input type="hidden" name="action" value="create_account" />
                  <div class="control-group">
                    <!-- Last Name -->
                    <label class="control-label" for="last_name">Last Name</label>
                    <div class="controls">
                      <input type="text" id="last_name" name="last_name" placeholder="" class="input-xlarge">
                      <p class="help-block">Please provide your last name</p>
                    </div>
                  </div>
                  <?php 
                    if(isset($_SESSION['error_last_name']))
                    {
                      echo $_SESSION['error_last_name'];   
                    }
                    unset($_SESSION['error_last_name']);          
                  ?>
       
                  <div class="control-group">
                    <!-- E-mail -->
                    <label class="control-label" for="email">E-mail</label>
                    <div class="controls">
                      <input type="text" id="email" name="email" placeholder="" class="input-xlarge">
                      <p class="help-block">Please provide your E-mail</p>
                    </div>
                  </div>
                  <?php 
                    if(isset($_SESSION['error_email']))
                    {
                      echo $_SESSION['error_email'];   
                    }
                    unset($_SESSION['error_email']);          
                  ?>

                  <div class="control-group">
                    <!-- Password-->
                    <label class="control-label" for="password">Password</label>
                    <div class="controls">
                      <input type="password" id="password" name="password" placeholder="" class="input-xlarge">
                      <p class="help-block">Password should be at least 6 characters</p>
                    </div>
                  </div>
                  <?php 
                    if(isset($_SESSION['error_password']))
                    {
                      echo $_SESSION['error_password'];   
                    }
                    unset($_SESSION['error_password']);          
                  ?>
               
                  <div class="control-group">
                    <!-- Password Confirm -->
                    <label class="control-label"  for="password_confirm">Password (Confirm)</label>
                    <div class="controls">
                      <input type="password" id="password_confirm" name="password_confirm" placeholder="" class="input-xlarge">
                      <p class="help-block">Please confirm password</p>
                    </div>
                  </div>
                  <?php 
                    if(isset($_SESSION['error_password_confirm']))
                    {
                      echo $_SESSION['error_password_confirm'];   
                    }
                    unset($_SESSION['error_password_confirm']); 
                  ?>
               
                  <div class="control-group">
                    <!-- Birth Date -->
                    <label class="control-label"  for="birth_date">Birth Date</label>
                    <div class="controls">
                      <input type="text" id="birth_date" name="birth_date" placeholder="" class="input-xlarge">
                      <p class="help-block">Please enter birth date in YYYY-MM-DD format</p>
                    </div>
                  </div>
                  <?php 
                    if(isset($_SESSION['error_birth_date']))
                    {
                      echo $_SESSION['error_birth_date'];   
                    }
                    unset($_SESSION['error_birth_date']);          
                  ?>

                  <div class="control-group">
                    <!-- Button -->
                    <div class="controls">
                      <!-- <button class="btn btn-success">Register</button> -->
                      <input type="submit" value="Create Account" class="btn btn-success">
                    </div>
                  </div>
                </form> <!-- end form for create account -->
              </div> <!-- end div for create account -->
            </div> <!-- end of myTabContent div --> 
          </div> <!-- end of well div -->
        </div> <!-- end div modal body -->
      </div> <!-- end login modal -->
    </div> <!-- end container div -->
  </body> <!-- end body -->
</html> <!-- end html -->
