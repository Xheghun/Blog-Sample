<?php
    require_once('includes/sessions.php');
    require_once("includes/db.php");
    require_once("includes/functions.php"); 
    $id = filter_input(INPUT_GET, "id");
    if(isset($id)) {
        $query = "DELETE FROM category WHERE id = '$id'";
        $exe = mysqli_query($con, $query);
        if($exe){
            $_SESSION['pending_message'] = "Category Deleted";
            redirect_to("categories.php");
        } else{
            $_SESSION['error_message'] = "Unable to delete at this time";
            redirect_to("categories.php");
        }
    }
?>
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

