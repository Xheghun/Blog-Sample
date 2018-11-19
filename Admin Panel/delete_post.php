<?php
    require_once 'includes/db.php';
    require_once 'includes/functions.php';
$delete_id = filter_input(INPUT_GET, 'delete');
$_SESSION['query'] = $delete_id;
    $query = "DELETE FROM admin_panel WHERE id = '$delete_id'";
    $execute = mysqli_query($con, $query);
    
    if($execute){
        $_SESSION['success_message']  =  "Post Deleted Successfully";
        redirect_to("dashboard.php");
    } else {
        $_SESSION['error_message'] = "Unable to Delete post";
        redirect_to("dashboard.php");
    }
    

?>

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 
 //TODO: MOVE TO add_new_post.php
<?php
    $target_dir= "../uploads/";
    $target_file = $target_dir. basename($_FILES["image"]["name"]);
    $uploadOK= true;
    $image_file_type = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
    $submit = filter_input(INPUT_POST, "submit");
    if (isset($submit)) {
        $check = getimagesize($_FILE["image"]["tmp_name"]);
        if($checkn != false ){
            echo 'File is an image - '.$check["mime"].".";
            $upload = true;
        } else {
            echo "File is not an image";
            $uploadOK = false;
        }
    }
    
    if(file_exists($target_file)) {
        echo 'Sorry, File already exist.';
        $uploadOK = false;
    }
    
    if($_FILES["image"]["size"] > 500000){
        echo 'Sorry your file is too large';
        $uploadOK = false;
    }
    
    if ($image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg" && $image_file_type != "gif") {
        echo 'Image format not supported';
        $uploadOK = false;
    }
    if($uploadOK == false){
    echo 'Sorry, your file was not uploaded';
    }else {
        if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)){
            echo "the file".basename($_FILE["image"]["name"])." has been uploaded.";
        }else {
            
        }
    }
