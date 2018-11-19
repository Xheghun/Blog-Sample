<?php require_once("includes/db.php");
require_once('includes/sessions.php');
require_once("includes/functions.php");
confirm_login();
?>
<?php
    $submit = filter_input(INPUT_POST, "submit");
    if (isset($submit)) {
        # code...
        $title = filter_input(INPUT_POST, "title");
         mysqli_real_escape_string($title);
        $category = filter_input(INPUT_POST, "category");
        mysqli_real_escape_string($category);
        $post = filter_input(INPUT_POST, "post");
         mysqli_real_escape_string($post);
        
        $current_time = time();
        $date_time = strftime("%B-%d-%Y %H:%M:%S",$current_time);
        $date_time;
        $admin = 'void';
        $image = $_FILES['image']['name'];
        $target = "../uploads/".basename($_FILES['image']['name']);
        
        $image_tmp = $_FILES['image']['tmp_name'];
        $imageUpoad = true;
        $image_file_type = strtolower(pathinfo($target,PATHINFO_EXTENSION));
        $check = getimagesize($image_tmp);
        
        if (empty($title)) {
            # code...
            $_SESSION["error_message"] = "title required";
            redirect_to("add_new_post.php");
        }
        elseif (strlen($title) < 4) {
            # code...
            $_SESSION["error_message"] = "title must be more than 3";
            redirect_to("add_new_post.php");
        }
        elseif (empty($category)) {
            # code...
            $_SESSION["error_message"] = "category must not be empty";
            redirect_to("add_new_post.php");
            }
        elseif (empty($post)) {
            # code...
            $_SESSION["error_message"] = "post must not be empty";
            redirect_to("add_new_post.php");
        }
        else{
            $query = "INSERT INTO admin_panel(date_time,title,category,author,img,post)  
                VALUES('$date_time','$title','$category','$admin','$image','$post')";   
            if($check != false){
//            $_SESSION['success_message'] = "file is an image";
            $imageUpoad = true;
//            redirect_to("add_new_post.php");
        } else {
            $_SESSION['error_message'] = "file is not an image";
            $imageUpoad = false;
            redirect_to("add_new_post.php");
            return;
            
        }
        
        if($_FILES["image"]["size"] > 100000*20){
            $_SESSION['error_message'] = "file is too large";
            $imageUpoad = false;
            redirect_to("add_new_post.php");
            exit;
        }
        
        if($image_file_type !="jpg" && $image_file_type !="png" && $image_file_type !="gif"){
            $_SESSION['error_message'] = "file format not supported, please make sure you've choosen an image";
            $imageUpoad = false;
            redirect_to("add_new_post.php");
            exit;
        }
        if($imageUpoad == FALSE){
            $_SESSION['error_message'] = "Server Error";
            $imageUpoad = FALSE;
            redirect_to("add_new_post.php");
            exit;
        } else {
            if(move_uploaded_file($_FILES['image']['tmp_name'],$target)){
                //$_SESSION['success_message'] = " not uploaded";
                $imageUpoad = true;
            } else {
                $_SESSION['error_message'] = "sorry image wasn't uploaded, Please try again";
                redirect_to("add_new_post.php");
                exit;
            }
        }
         $execute = mysqli_query($con,$query);
            if ($execute) {
                # code...
                $_SESSION['success_message'] = "Post Added Successfully";
                redirect_to("add_new_post.php");
            }else{
                $_SESSION['error_message'] = "Something Went Wrong Try Again";
                redirect_to("add_to_post.php");
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
    <title>Add New Post</title>
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
                        <li class="nav-item active"><a href="add_new_post.php"><span  class="fa fa-list-alt"></span>&nbsp; Add New Post</a></li>
                        <li class="nav-item" ><a href="categories.php"><span  class="fa fa-tags"></span>&nbsp; Categories</a></li>
                        <li class="nav-item"><a href="admins.php"><span  class="fa fa-user"></span>&nbsp; Manage Admin</a></li>
                        <li class="nav-item"><a href="view_comments.php"><span  class="fa fa-comment"></span>&nbsp; Comments<span class="btn-warning count pull-right"><?php if (!count_comment() <= 0){    echo count_comment();}?></span></a></li>
                        <li class="nav-item"><a href="../blog.php?Page=0"><span  class="fa fa-globe"></span>&nbsp; Live Blog</a></li>
                        <li class="nav-item"><a href="logout.php"><span  class="fa fa-door-open"></span>&nbsp; Logout</a></li>
                    </ul>
                </div><!-- End of Side Area -->
                <div  class="col-sm-10">
                    <h4 class="tableHeading">Add New Post</h4>
                    <div><?php echo error_message();
                            echo success_message();
                        ?>
                    </div>
                    <div>
                        <form action="add_new_post.php" method="post" enctype="multipart/form-data">
                            <fieldset>
                                <div  class="form-group">
                                    <label for="title"><span class="fieldInfo">Title:</span></label>
                                    <input  class="form-control" placeholder="Post Title" type="text" id="title" name="title">
                                </div>
                                <div class="form-group">
                                    <label for="category" ><span class="fieldInfo"> Category:</span></label>
                                    <?php
                                        $conect = mysqli_connect("localhost","root","","void_io");
                                        $sql = "SELECT * FROM category";
                                        $exe = mysqli_query($conect,$sql);?>
                                    <select class="form-control" name="category" id="">
                                    
                                    <option value="" disabled="disabled" selected="selected" >Please Select a Category</option>
                                    <?php 
                                        if ($exe) {
                                            # code...
                                            while ($rows = mysqli_fetch_array($exe)) {
                                                # code...
                                                $categoryName = $rows['c_name'];
                                    ?>
                                        <option value="<?php echo $categoryName;?>"><?php echo $categoryName;?></option>
                                    <?php      }
                                        } ?>
                                    </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="imageselect"><span class="fieldInfo">Select Image</span></label>
                                        <input type="file" class="form-control" name="image" id="imageselect">
                                    </div>
                                    <div class="form-group">
                                        <label for="post" class="fieldInfo">Post Content:</label>
                                        <textarea name="post" id="post" class="form-control" cols="30" rows="10" placeholder="Post Content"></textarea>
                                    </div>
                                <input style="margin-bottom:10px;" type="submit" class="btn custom-btn btn-md"  name="submit" value="Add Post">
                            </fieldset>
                        </form>
                    </div>                                      
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