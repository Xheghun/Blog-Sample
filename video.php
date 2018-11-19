<?php
    $target_dir= "uploads/";
    $target_file = $target_dir. basename($_FILES["vid"]["name"]);
    $uploadOK= true;
    $image_file_type = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
    $submit = filter_input(INPUT_POST, "submit");
    if (isset($submit)) {
        $check = getimagesize($_FILE["vid"]["tmp_name"]);
        if($checkn != false ){
            echo 'File is not a video - '.$check["mime"].".";
            $upload = true;
        } else {
            echo "File is not a video";
            $uploadOK = false;
        }
    }
    
    if(file_exists($target_file)) {
        echo 'Sorry, File already exist.';
        $uploadOK = false;
    }
    
    if($_FILES["vid"]["size"] > 100000*5000){
        echo 'Sorry your file is too large';
        $uploadOK = false;
    }
    
    if ($image_file_type != "mp4" && $image_file_type != "avi" && $image_file_type != "mkv") {
        echo 'Image format not supported';
        $uploadOK = false;
    }
    if($uploadOK = false){
    echo 'Sorry, your file was not uploaded';
    }else {
        if(move_uploaded_file($_FILES["vid"]["tmp_name"], $target_file)){
            echo "the file".basename($_FILES["vid"]["name"])." has been uploaded.";?>
            <video width="320" height="240" controls>
                <source src="uploads/io.mp4" type="video/mp4">
            </video>
<?php
            
        }else {
            
        }
    }
?>
<html>
    <head></head>
    <body>
        
        <form action="video.php" method="post" enctype="multipart/form-data">
            <input type="file" name="vid"/>
            <input type="submit" value="submit" />
        </form>
    </body>
</html>

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

