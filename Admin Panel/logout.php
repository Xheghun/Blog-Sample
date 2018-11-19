<?php
    require_once('includes/sessions.php');
    require_once("includes/functions.php");
    
    $_SESSION["user_id"] = null;
    $_SESSION["username"] = null;
    $_SESSION["success_message"] = null;
    $_SESSION["error_message"] = null;
    $_SESSION["pending_message"] = null;
    
    session_destroy();
    redirect_to("login.php");
?>

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

