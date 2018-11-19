<?php
    $comment_button = filter_input(INPUT_POST, "submit_comment");
    if(isset($comment_button)){
        $con_ = mysqli_connect("localhost", "root", "", "void_io");
        
        $name = filter_input(INPUT_POST, "name");
        $email = filter_input(INPUT_POST, "email");
        $comment = filter_input(INPUT_POST, "comment");
        
        //mysqli_real_escape_string($name);
        //mysqli_real_escape_string($email);
        //mysqli_real_escape_string($comment);
        
        $current_time = time();
        $date_time = strftime("%B-%d-%Y %H:%M:%S",$current_time);
        $status = "pending";
        if((empty($name) || $name == null) || (empty($comment) || $comment == null)) {
            $_SESSION["error_message"] = "fields must be filled";
        }elseif ($comment > 500) {
            $_SESSION["error_message"] = "comment is too large, only 500 characters allowed";
        }else{
            $pid = filter_input(INPUT_GET,"id");
            $query = "INSERT INTO comments (date_time, name, email, comment, status, post_id) VALUES('$date_time','$name','$email','$comment','$status','$pid')";
            $exe = mysqli_query($con_, $query);
            
            if($exe){
                $_SESSION["pending_message"] = "comment submitted, awaiting approval.";
            } else {
                $_SESSION["error_message"] = "Error, comment not submitted.";
            }
        }
    }
?>

<!-- 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */ --!>

