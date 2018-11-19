<?php
    session_start();

    function error_message(){
        if (isset($_SESSION["error_message"])) {
            # code...
            $output = "<div class=\"alert alert-danger\">";
            $output .=htmlentities($_SESSION["error_message"]);
            $output .="</div>";
            $_SESSION["error_message"]  =  null;
            return  $output;
        }
    }

    function success_message(){
        if (isset($_SESSION["success_message"])) {
            # code...
            $output = "<div class=\"alert alert-success\">";
            $output .=htmlentities($_SESSION["success_message"]);
            $output .="</div>";
            $_SESSION["success_message"]  =  null;
            return  $output;
        }
    }
    
    function pending_message(){
        if (isset($_SESSION["pending_message"])) {
            # code...
            $output = "<div class=\"alert alert-warning\">";
            $output .=htmlentities($_SESSION["pending_message"]);
            $output .="</div>";
            $_SESSION["pending_message"]  =  null;
            return  $output;
        }
    }
    
    function count_comment(){
        $conx = mysqli_connect("localhost", "root", "", "void_io");
        $Approvedcomment = "SELECT COUNT(*) FROM comments WHERE status = 'pending'";
        $exx = mysqli_query($conx, $Approvedcomment);
                                    
        $row= mysqli_fetch_array($exx);
        $total = array_shift($row);
        return $total;
    }
?>