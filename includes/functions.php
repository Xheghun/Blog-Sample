<?php
    function  redirect_to($new_location){
        header("Location: ".$new_location);
        exit;
    }
    function login_attempt($Username,$Password){
        $Query="SELECT * FROM admins
        WHERE username='$Username' AND password='$Password'";
        $conn = mysqli_connect("localhost", "root", "", "void_io");
        $Execute=mysqli_query($conn,$Query);
        if($admin=mysqli_fetch_assoc($Execute)){
            return $admin;
        }else{
            return null;
        }
    }
    function login(){
        if(isset($_SESSION["user_id"])){
            return true;
        }
    }
    
    function confirm_login(){
        if(!login()){
            redirect_to("login.php");
        }
    }
?>