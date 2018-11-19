<?php 
require_once("includes/db.php");
require_once('includes/sessions.php');
require_once("includes/functions.php");
confirm_login();

    $submit = filter_input(INPUT_POST, "submit");
    if(isset($submit))  {
        $fullname = filter_input(INPUT_POST, "fullname");
        $username = filter_input(INPUT_POST, "username");
        $email = filter_input(INPUT_POST, "email");
        $password  = filter_input(INPUT_POST, "password");
        $confirmPass  = filter_input(INPUT_POST, "confirmpass");
        $current_time = time();
        mysqli_real_escape_string($category);
        strip_tags($category);
        stripslashes($category);
        $date_time = strftime("%B-%d-%Y %H:%M:%S",$current_time);
        $date_time;
        if(empty($fullname)){
            $_SESSION["error_message"] ="please enter fullname";
            redirect_to("admins.php");
            exit;
        }
        elseif (empty ($username)) {
            # code...
            $_SESSION["error_message"] ="username required";
            redirect_to("admins.php");
        }elseif (strlen ($password) < 5) {
            $_SESSION["error_message"] ="password needs to be at least 5 characters.";
            redirect_to("admins.php");
        }
        elseif ($password !== $confirmPass) {
            $_SESSION["error_message"] ="password doesn't match";
            redirect_to("admins.php");
        }else{
            //global $con;
            $priv = "false";
            $admin = $_SESSION['fullname'];
            $query = "INSERT INTO admins(date_time,fullname,username,email,password,privileged,added_by)"
                    . " VALUES('$date_time','$fullname','$username','$email','$password','$priv','$admin')";
            $execute = mysqli_query($con,$query);

            if ($execute) {
                # code...
                 $_SESSION["success_message"]  = "Success, new Admin added.";
                redirect_to("admins.php");
            }else {
                # code...
                $_SESSION["error_message"] = "failed, unable to add Admin.";
                redirect_to("admins.php");
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
    <?php include("includes/head.php");?>
    <link rel="stylesheet" href="css/admin_styles.css">
    <style>
        .fieldInfo{
            color: rgb(251, 152, 13);
            font-family: Bitter,Georgia,"Times New Roman",Times,Serif;
            font-size: 1.2em;
        }
    </style>
    <title>Admins</title>
</head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-2">
                    <div style="margin-top: 1cm;">
                        <img width="40" style="margin-right: 4px;" height="40" src="../images/user.png" class="img-responsive img-circle pull-left">
                        <h3 style="margin-top: 1cm; color: white;"><?php echo $_SESSION['username'];?></h3>
                    </div>
                    <ul style="margin-top: 1cm;" id="side_menu"  class="nav nav-pills nav-stacked">
                        <li class="nav-item"><a href="dashboard.php"><span  class="fa fa-th"></span>&nbsp; Dashboard</a></li>
                        <li class="nav-item"><a href="add_new_post.php"><span  class="fa fa-list-alt"></span>&nbsp; Add New Post</a></li>
                        <li class="nav-item"><a href="categories.php"><span  class="fa fa-tags"></span>&nbsp; Categories</a></li>
                        <li class="active nav-item"><a href="admins.php" class="active"><span  class="fa fa-user"></span>&nbsp; Manage Admin</a></li>
                        <li class="nav-item"><a href="view_comments.php"><span  class="fa fa-comment"></span>&nbsp; Comments<span class="btn-warning count pull-right"><?php if (!count_comment() <= 0){    echo count_comment();}?></span></a></li>
                        <li class="nav-item"><a href="../blog.php?Page=0"><span  class="fa fa-globe"></span>&nbsp; Live Blog</a></li>
                        <li class="nav-item"><a href="logout.php"><span  class="fa fa-door-open"></span>&nbsp; Logout</a></li>
                    </ul>
                </div><!-- End of Side Area -->
                <div  class="col-sm-10">
                    <h4 class="tableHeading">Create Admin</h4>
                    <div><?php echo error_message();
                                echo success_message();
                                echo pending_message();?></div>
                    <div>
                        <form action="admins.php" method="post">
                            <fieldset>
                                 <div  class="form-group">
                                    <label for="fullname"><span class="fieldInfo">Full Name:</span></label>
                                    <input  class="form-control" placeholder="Full Name" type="text" id="fullname" name="fullname">
                                </div>
                                <div  class="form-group">
                                    <label for="username"><span class="fieldInfo">Username:</span></label>
                                    <input  class="form-control" placeholder="Username" type="text" id="username" name="username">
                                </div>
                                <div  class="form-group">
                                    <label for="email"><span class="fieldInfo">Email:</span></label>
                                    <input  class="form-control" placeholder="name@example.com" type="email" id="email" name="email">
                                </div>
                                 <div  class="form-group">
                                    <label for="categoryname"><span class="fieldInfo">Password:</span></label>
                                    <input  class="form-control" placeholder="password" type="password" id="password" name="password">
                                </div>
                                 <div  class="form-group">
                                    <label for="confirmpass"><span class="fieldInfo">Confirm  Password:</span></label>
                                    <input  class="form-control" placeholder="Confirm Password" type="password" id="confirmpass" name="confirmpass">
                                </div>
                                <input style="margin-bottom:10px;" type="submit" class="btn custom-btn btn-md"  name="submit" value="Register">
                            </fieldset>
                        </form>
                    </div>
                    <h4 class="tableHeading">Manage Admins</h4>
                    <div class="table-responsive">
                        <table  class="table  table-striped table-hover">
                            <tr>
                                <th>S/N</th>
                                <th>Added On</th>
                                <th>Username</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                            <?php
                                global $con;
                                $viewQuery = "SELECT * FROM admins ORDER BY date_time desc";
                                $execute = mysqli_query($con,$viewQuery);
                                $sn = 0;
                                while($rows = mysqli_fetch_array($execute)) {
                                    # code...
                                    $id = $rows['id'];
                                    $date = $rows['date_time'];
                                    $category_name = $rows['username'];
                                    $creator = $rows['added_by'];
                                    $sn++;
                            ?>
                            <tr>
                                <td><?php echo $sn ?></td>
                                <td><?php echo $date ?></td>
                                <td><?php echo $category_name ?></td>
                                <td><?php echo $creator ?></td>
                                <td ><a href="delete_admin.php?id=<?php echo $id;?>"><span class="btn btn-danger glyphicon glyphicon-trash"></span></a></td>
                            </tr>

                        <?php  }?>
                        </table>
                    </div>
                </div><!-- End of Main Area -->
            </div><!-- End of Row -->
        </div><!-- End container-fluid -->
        <footer class="panel-footer footer font-small--blue lighten-5">
        <?php include("../includes/footer.php")?>
    </footer>
    <div  style="height: 10px; background: #27AAE1"></div>
    </body>
</html>