<?php
    require_once("includes/db.php");
    require_once('includes/sessions.php');
    require_once("includes/functions.php"); 
   
    $submit = filter_input(INPUT_POST, "submit");
    
    if(isset($submit)){
        $username = filter_input(INPUT_POST, "username");
        $password = filter_input(INPUT_POST, "password");
        
        mysqli_real_escape_string($username);
        mysqli_real_escape_string($password);
        
        
        if(empty($username) || empty($password)) {
            $_SESSION["error_message"] = "all fields are required";
            redirect_to("login.php");  
        }
        else {
          
           $found_account = login_attempt($username,$password);
           $_SESSION["user_id"]  = $found_account["id"];
           $_SESSION["username"]  = $found_account["username"];
           $_SESSION["fullname"]  = $found_account["fullname"];
            if($found_account){
               $_SESSION["success_message"] = "Welcome "
                     . "{$_SESSION["username"]}";
               redirect_to("dashboard.php"); 
            } else {
                $_SESSION["error_message"] = "user is not registered";
                redirect_to("login.php");
            }
        }
    }
      
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Admin Login</title>
        <link rel="stylesheet" type="text/css" href="css/loginForm.css"/>
<!--  <link rel="stylesheet" type="text/css" href="css/admin_styles.css"/>-->
        <?php require_once 'includes/head.php';?>
    </head>
    <body>
    <div class="line" style="height: 10px; background: #cc0099;"></div>
        <nav class="navbar navbar-expand-lg navbar-dark stylish-color-dark indigo fixed-top">
            <div class="container">
                <!-- Navbar brand -->
                <a class="navbar-brand" href="../blog.php?Page=0"><img class="img-circle img-responsive" style="margin-top: 10px; border-radius: 100%;" width="50" height="50" src="../images/logo.png"/></a>

                <!-- Collapse button -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav" aria-controls="basicExampleNav"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Collapsible content -->
                <div class="collapse navbar-collapse show" id="basicExampleNav">

                    <!-- Links -->
                    <ul class="navbar-nav mr-auto smooth-scroll">
                        <li class="nav-item">
                            <a class="nav-link" href="../blog.php?Page=0">Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Service
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact Us</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                    </ul>
<!--                    <form action="../blog.php" method="get" class="form-inline">-->
<!--                        <div class="md-form mt-0">-->
<!--                            <input type="text" class="form-control mr-sm-2" aria-label="Search" placeholder="Search" name="search"/>-->
<!--                            <button type="submit" class="btn btn-defualt btn-sm" value="query" name="searchButton"><span class="fa fa-search"></span></button>-->
<!--                        </div>-->
<!--                    </form>-->
                    <ul class="navbar-nav mr-auto mt-auto">
                        <li class="nav-item">
                        </li>
                    </ul>
                    <!-- Links -->
                </div>
                <!-- Collapsible content -->
            </div>
        </nav>
    <div style="height: 10px; background: #cc0099;"></div>
    <main class="container" style="margin-top: 2.5cm;">
    <div class="container">
            <form action="login.php" method="post" class="p-5 card mt-5">
                <div class="container">


                </div>
                <h4 class="form-signin-heading">Welcome! Please Sign In</h4>
                <hr class="colorgraph"/>

                <div class="md-form form-sm">
                    <i class="fa fa-user prefix custom-icon"></i>
                    <input type="text" id="username" class="form-control" name="username" required="required" />
                    <label for="username">Enter Username</label>
                </div>

                <div class="md-form form-sm">
                    <i  class="fa fa-lock prefix custom-icon"></i>
                    <input id="password" type="password" class="form-control" name="password" required="required"/>
                    <label for="password">Enter Password</label>
                </div>
        <button class="btn btn-lg btn-block custom-btn btn-outline-primary mt-3"  name="submit" value="Login" type="Submit">Login</button>
        <?php echo error_message();
        echo success_message();?>
        </form>
    </div>
    </main>

    <footer>

    </footer>

    <?php include "includes/head.php"?>
    </body>
</html>