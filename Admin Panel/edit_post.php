<?php require_once("includes/db.php"); ?>
<?php require_once("includes/sessions.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_login();?>
<?php
$submit = filter_input(INPUT_POST, "submit");
if(isset($submit)){
$Title= filter_input(INPUT_POST, "Title");
        mysqli_real_escape_string($Title);
$Category= filter_input(INPUT_POST, "Category");
        mysqli_real_escape_string($category);
$Post= filter_input(INPUT_POST, "Post");
        mysqli_real_escape_string($Post);
//date_default_timezone_set("Asia/Karachi");
$CurrentTime=time();
//$DateTime=strftime("%Y-%m-%d %H:%M:%S",$CurrentTime);
$DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
$DateTime;
//$Admin=$_SESSION["Username"];

$Admin = $_SESSION["username"];
$Image=$_FILES["Image"]["name"];
$Target="Uploads/".basename($_FILES["Image"]["name"]);
if(empty($Title)){
	$_SESSION["error_message"]="Title can't be empty";
	redirect_to("dashboard.php");
	
}elseif(strlen($Title)<2){
	$_SESSION["error_message"]="Title Should be at-least 2 Characters";
	redirect_to("dashboard.php");
	
}else{
	
	$EditFromURL= filter_input(INPUT_GET, "Edit");
	$Query="UPDATE admin_panel SET date_time='$DateTime', title='$Title',
	category='$Category', author='$Admin',img='$Image',post='$Post'
	WHERE id='$EditFromURL'";
	
	$Execute=mysqli_query($con,$Query);
	move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
	if($Execute){
	$_SESSION["success_message"]="Post Updated Successfully";
	redirect_to("Dashboard.php");
	}else{
	$_SESSION["error_message"]="Something Went Wrong. Try Again !";
	redirect_to("Dashboard.php");
		
	}
	
}	
	
}

?>

<!DOCTYPE>

<html>
	<head>
		<title>Edit Post</title>
                <?php require_once 'includes/head.php';?>
                
		<link rel="stylesheet" href="css/admin_styles.css">
<style>
	.FieldInfo{
    color: rgb(251, 174, 44);
    /*font-family: Bitter,Georgia,"Times New Roman",Times,serif;*/
    font-size: 1.2em;
}

</style>
                
	</head>
	<body>
		
<div class="container-fluid">
<div class="row">
	
	<div class="col-sm-2">
	
	<ul id="Side_Menu" class="nav nav-pills nav-stacked">
	<li ><a href="Dashboard.php">
	<span class="glyphicon glyphicon-th"></span>
	&nbsp;Dashboard</a></li>
	<li class="active"><a href="AddNewPost.php">
	<span class="glyphicon glyphicon-list-alt"></span>
	&nbsp;Add New Post</a></li>
	<li ><a href="Categories.php">
	<span class="glyphicon glyphicon-tags"></span>
	&nbsp;Categories</a></li>
        <li><a href="admins.php">
	<span class="glyphicon glyphicon-user"></span>
	&nbsp;Manage Admins</a></li>
        <li><a href="view_comments.php">
	<span class="glyphicon glyphicon-comment"></span>
	&nbsp;Comments<span class="btn-warning count pull-right"><?php if (!count_comment() <= 0){    echo count_comment();}?></span></a></li>
        <li><a href="../blog.php?Page=0">
	<span class="glyphicon glyphicon-equalizer"></span>
	&nbsp;Live Blog</a></li>
        <li><a href="logout.php">
	<span class="glyphicon glyphicon-log-out"></span>
	&nbsp;Logout</a></li>	
		
	</ul>
	
	
	
	
	</div> <!-- Ending of Side area -->
	<div class="col-sm-10">
            <h4 class="tableHeading">Update Post</h4>
	<?php echo error_message();
	      echo success_message();
	?>
<div>
	<?php
	$SerachQueryParameter = filter_input(INPUT_GET, "edit");
	$ConnectingDB;
	$Query="SELECT * FROM admin_panel WHERE id='$SerachQueryParameter'";
	$ExecuteQuery=mysqli_query($con,$Query);
	while($DataRows=mysqli_fetch_array($ExecuteQuery)){
		$TitleToBeUpdated=$DataRows['title'];
		$CategoryToBeUpdated=$DataRows['category'];
		$ImageToBeUpdated=$DataRows['img'];
		$PostToBeUpdated=$DataRows['post'];
		
	}
	
	
	?>
    <form action="edit_post.php?Edit=<?php echo $SerachQueryParameter; ?>" method="post" enctype="multipart/form-data">
	<fieldset>
	<div class="form-group">
	<label for="title"><span class="FieldInfo">Title:</span></label>
	<input value="<?php echo $TitleToBeUpdated; ?>" class="form-control" type="text" name="Title" id="title" placeholder="Title">
	</div>
	<div class="form-group">
	<span class="FieldInfo"> Existing Category: </span>
	<?php echo $CategoryToBeUpdated;?>
	<br>
	<label for="categoryselect"><span class="FieldInfo">Category:</span></label>
	<select class="form-control" id="categoryselect" name="Category" >
	<?php
    $ViewQuery="SELECT * FROM category ORDER BY date_time desc";
    $conn = mysqli_connect("localhost", "root", "", "void_io");
    $Execute=mysqli_query($conn,$ViewQuery);
while($DataRows=mysqli_fetch_array($Execute)){
	$Id=$DataRows["id"];
	$CategoryName=$DataRows["c_name"];
?>	
            <option value="<?php echo $CategoryName?>"> <?php echo $CategoryName; ?> </option>
	<?php } ?>
			
	</select>
	</div>
	<div class="form-group">
		<span class="FieldInfo"> Existing Image: </span>
	<img src="../uploads/<?php echo $ImageToBeUpdated;?>" width=170px; height=70px;>
	<br>
	<label for="imageselect"><span class="FieldInfo">Select Image:</span></label>
	<input type="File" class="form-control" name="Image" id="imageselect">
	</div>
	<div class="form-group">
	<label for="postarea"><span class="FieldInfo">Post:</span></label>
	<textarea class="form-control" name="Post" id="postarea">
		<?php echo $PostToBeUpdated; ?>
	</textarea>
	<br>
<input class="btn custom-btn" type="Submit" name="Submit" value="Update Post">
	</fieldset>
	<br>
</form>
</div>



	</div> <!-- Ending of Main Area-->
	
</div> <!-- Ending of Row-->
	
</div> <!-- Ending of Container-->
<footer class="page-footer footer font-small--blue lighten-5 ">
    <?php include_once '../includes/footer.php'; ?>
</footer>
<div style="height: 10px; background: #27AAE1;"></div> 

	    
	</body>
</html>