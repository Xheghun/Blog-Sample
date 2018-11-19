<?php require_once("includes/db.php");
require_once('includes/sessions.php');
require_once("includes/functions.php");
confirm_login();
    $sub = filter_input(INPUT_GET, "submit");
    if(isset($sub))  {
        $admin = "void";
        $fb = "";
        $category = filter_input(INPUT_GET, "categoryname");
        $current_time = time();
        mysqli_real_escape_string($category);
        strip_tags($category);
        stripslashes($category);
        $date_time = strftime("%B-%d-%Y %H:%M:%S",$current_time);
        $date_time;
        if(empty($category)){
            $_SESSION["error_message"] ="field must be filled";
            redirect_to("categories.php");
            exit;
        }
        elseif (strlen($category)  > 99) {
            # code...
            $_SESSION["error_message"] ="Category name is too long";
            redirect_to("categories.php");
        }
        else{
            //global $con;
            $query = "INSERT INTO category(date_time,c_name,creator) VALUES('$date_time','$category','$admin')";
            $execute = mysqli_query($con,$query);

            if ($execute) {
                # code...
                 $_SESSION["success_message"]  = "category added";
                redirect_to("categories.php");
            }else {
                # code...
                $_SESSION["error_message"] = "failed";
                redirect_to("categories.php");
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
    <title>Admin  Dashboard</title>
</head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-2">
                    <div style="margin-top: 1cm;">
                        <img width="40" style="margin-right: 4px; border-radius: 100%;" height="40" src="../images/user.png" class="img-responsive img-circle pull-left">
                        <h3 style="margin-top: 1cm; color: white;"><?php echo $_SESSION['username'];?></h3>
                    </div>
                    <ul style="margin-top: 1cm;" id="side_menu"  class="nav nav-pills nav-stacked">
                        <li class="nav-item" ><a href="dashboard.php"><span  class="fa fa-th"></span>&nbsp; Dashboard</a></li>
                        <li class="nav-item"><a href="add_new_post.php"><span  class="fa fa-list-alt"></span>&nbsp; Add New Post</a></li>
                        <li class="active nav-item"><a href="categories.php"><span  class="fa fa-tags"></span>&nbsp; Categories</a></li>
                        <li class="nav-item"><a href="admins.php"><span  class="fa fa-user"></span>&nbsp; Manage Admin</a></li>
                        <li class="nav-item"><a href="view_comments.php"><span  class="fa fa-comment"></span>&nbsp; Comments<span class="btn-warning count pull-right"><?php if (!count_comment() <= 0){    echo count_comment();}?></span></a></li>
                        <li class="nav-item"><a href="../blog.php"><span  class="fa fa-globe"></span>&nbsp; Live Blog</a></li>
                        <li class="nav-item"><a href="logout.php"><span  class="fa fa-door-open"></span>&nbsp; Logout</a></li>
                    </ul>
                </div><!-- End of Side Area -->
                <div  class="col-sm-10">
                    <h4 class="tableHeading">Manage Categories</h4>
                    <div><?php echo error_message();
                                echo success_message();
                                echo pending_message();?></div>
                    <div>
                        <form action="categories.php" method="get">
                            <fieldset>
                                <div  class="form-group">
                                    <label for="categoryname"><span class="fieldInfo">Name:</span></label>
                                    <input  class="form-control" placeholder="name" type="text" id="categoryname" name="categoryname">
                                </div>
                                <input style="margin-bottom:10px;" type="submit" class="custom-btn btn btn-md"  name="submit" value="Add Category">
                            </fieldset>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table  class="table  table-striped table-hover">
                            <tr>
                                <th>S/N</th>
                                <th>Added On</th>
                                <th>Category Name</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                            <?php
                                global $con;
                                $viewQuery = "SELECT * FROM category ORDER BY date_time desc";
                                $execute = mysqli_query($con,$viewQuery);
                                $sn = 0;
                                while($rows = mysqli_fetch_array($execute)) {
                                    # code...
                                    $id = $rows['id'];
                                    $date = $rows['date_time'];
                                    $category_name = $rows['c_name'];
                                    $creator = $rows['creator'];
                                    $sn++;
                            ?>
                            <tr>
                                <td><?php echo $sn ?></td>
                                <td><?php echo $date ?></td>
                                <td><?php echo $category_name ?></td>
                                <td><?php echo $creator ?></td>
                                <td ><a href="delete_cat.php?id=<?php echo $id;?>"><span class="btn btn-outline-danger btn-sm "><i class="fa fa-trash"></i></span></a></td>
                            </tr>

                        <?php  }?>
                        </table>
                    </div>
                </div><!-- End of Main Area -->
            </div><!-- End of Row -->
        </div><!-- End container-fluid -->
        <footer class="panel-footer footer font-small--blue lighten-5">
        <?php include("includes/footer.php")?>
    </footer>
    <div  style="height: 10px; background: #27AAE1"></div>
    </body>
</html>