<?php
    require_once('includes/db.php');
    require_once('includes/sessions.php');
    require_once("includes/functions.php");
    
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
        $admin = 'void';
        $image = $_FILES['image']['name'];
        $target = "../uploads/".basename($_FILES['image']['name']);
        if (empty($title)) {
            # code...
            $_SESSION["error_message"] = "title required";
            redirect_to("edit_post.php");
        }
        elseif (strlen($title) < 4) {
            # code...
            $_SESSION["error_message"] = "title must be more than 3";
            redirect_to("edit_post.php");
        }
        elseif (empty($category)) {
            # code...
            $_SESSION["error_message"] = "category must not be empty";
            redirect_to("edit_post.php");
            }
        elseif (empty($post)) {
            # code...
            $_SESSION["error_message"] = "post must not be empty";
            redirect_to("edit_post.php");
        } else{
            $edit_id = filter_input(INPUT_POST, "edit");
            $query = "UPDATE `admin_panel` SET `date_time` ='$date_time', `title` ='$title',
             `category` ='$category', `author` ='$admin'
            `img` ='$image', `post` ='$post' WHERE `id` ='$edit_id' ";
            $_SESSION['query'] = $query;

            $conect_db  = mysqli_connect("localhost","root","","void_io");
            $execute = mysqli_query($conect_db,$query);
            move_uploaded_file($_FILES['image']['tmp_name'],$target);
            if ($execute) {
                # code...
                $_SESSION['success_message'] = "Post Updated Successfully";
                redirect_to("dashboard.php");
            }else{
                $_SESSION['error_message'] = "Something Went Wrong Try Again";
                redirect_to("dashboard.php");
            }
        }
    }
