<?php require_once('includes/sessions.php');
    require_once("includes/db.php");
    require_once("includes/functions.php"); 
    confirm_login();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <?php include("includes/head.php");?>
        <link rel="stylesheet" href="css/admin_styles.css">
        <title>Admin  Dashboard</title>
    </head>
    <body>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-2">
                        <div style="margin-top: 1cm;">
                        <img width="40" style="margin-right: 4px;" height="40" src="../images/user.png" class="img-responsive img-circle pull-left">
                        <h3 style="margin-top: 1cm; color: white;"><?php echo $_SESSION['username'];?></h3>
                    </div>
                        <ul style="margin-top: 1cm;" id="side_menu"  class="nav nav-pills nav-stacked" style="margin-top:30px;">
                            <li class="nav-item"><a href="dashboard.php"><span  class="fa fa-th"></span>&nbsp; Dashboard</a></li>
                            <li class="nav-item"><a href="add_new_post.php"><span  class="fa fa-list-alt"></span>&nbsp; Add New Post</a></li>
                            <li class="nav-item"><a href="categories.php"><span  class="fa fa-tags"></span>&nbsp; Categories</a></li>
                            <li class="nav-item"><a href="admins.php"><span  class="fa fa-user"></span>&nbsp; Manage Admin</a></li>
                            <li class="active nav-item"><a href="view_comments.php"><span  class="fa fa-comment"></span>&nbsp; Comments<?php if (!count_comment() <= 0){?>  <span class="btn-warning count pull-right"> <?php echo count_comment();?> </span><?php } ?></a></li>
                            <li class="nav-item"><a href="../blog.php?Page=0"><span  class="fa fa-globe"></span>&nbsp; Live Blog</a></li>
                            <li class="nav-item"><a href="logout.php"><span  class="fa fa-door-open"></span>&nbsp; Logout</a></li>
                        </ul>
                    </div><!-- End of Side Area -->
                    <div class="col-sm-10"><!-- Main Area -->
                        <div>
                            <?php echo error_message();
                                echo success_message();
                                // echo $_SESSION['query'];//."<br>".$_SESSION['edit'];
                            ?>
                        </div>
                        
                        <h4 class="tableHeading" style="">Un-Approved Comments</h4>
                        <hr/>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <th>S/N</th>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Comment</th>
                                    <th>Approve</th>
                                    <th>Delete</th>
                                    <th>Details</th>
                                </tr>
                                <?php
                                    $qury = "SELECT * FROM comments WHERE status='pending' ORDER BY date_time desc";
                                    $execute = mysqli_query($con, $qury);
                                    $id_ = 0;
                                    if($execute){
                                        while($rows = mysqli_fetch_array($execute)) {
                                            $date = $rows["date_time"];
                                            $name = $rows["name"];
                                            $email = $rows["email"];
                                            $comment = $rows["comment"];
                                            $status = $rows["status"];
                                            $pid = $rows["id"];
                                            $p_id = $rows["post_id"];
                                            $id_++;
                                ?>
                                <tr>
                                    <td><?php echo $id_;?></td>
                                    <td><?php echo ucwords($name);?></td>
                                    <td><?php echo $date;?></td>
                                    <td><?php echo $comment;?></td>
                                    <td><a href="approve_comment.php?id=<?php echo $pid;?>"><span class="btn btn-outline-success btn-sm"><i class="fa fa-check"></i></span></a></td>
                                    <td><a href="delete_comment.php?id=<?php echo $pid;?>"><span class="btn btn-outline-danger btn-sm "><i class="fa fa-trash"></i></span></a></td>
                                    <td><a href="fullpost.php?id=<?php echo $p_id;?>& post_name=<?php echo '';?>"><span class="btn btn-outline-info btn-sm"><i class="fa fa-globe"></i></span></a></td>
                                </tr>
                                <?php }}?>
                            </table>
                        </div>
                        <h4 class="tableHeading">Approved Comments</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <th>S/N</th>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Comment</th>
                                    <th>Approved By</th>
                                    <th>Dis-Approve</th>
                                    <th>Delete</th>
                                    <th>Details</th>
                                </tr>
                                <?php
                                    $query = "SELECT * FROM comments WHERE status='approved' ORDER BY date_time desc";
                                    //$conn = mysqli_connect("localhost","root","","void_io");
                                    $executes = mysqli_query($con, $query);
                                    $id = 0;
                                    if($executes) {
                                        while($rows = mysqli_fetch_array($executes)) {
                                            $date = $rows["date_time"];
                                            $name = $rows["name"];
                                            $email = $rows["email"];
                                            $comment = $rows["comment"];
                                            $status = $rows["status"];
                                            $p_id = $rows["id"];
                                            $pid = $rows["post_id"];
                                            $approved_by = $rows["approved_by"];
                                            $id++;
                                ?>
                                <tr>
                                    <td><?php echo $id;?></td>
                                    <td><?php echo ucwords($name);?></td>
                                    <td><?php echo $date;?></td>
                                    <td><?php echo $comment;?></td>
                                    <td><?php echo $approved_by;?></td>
                                    <td><a href="disapprove_comment.php?id=<?php echo $p_id;?>"><span class="btn btn-outline-warning btn-sm"><i class="fa fa-undo"></i></span></a></td>
                                    <td><a href="delete_comment.php?id=<?php echo $p_id;?>"><span class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i></span></a></td>
                                    <td><a href="../fullpost.php?id=<?php echo $pid;?>& post_name=<?php echo '';?>"><span class="btn btn-outline-info btn-sm"><i class="fa fa-globe"></i></span></a></td>
                                </tr>
                                <?php }}?>
                            </table>
                        </div>
                    </div><!-- End of Main Area -->
                </div><!-- End of Row -->
            </div><!-- End container-fluid -->
            <footer class="page-footer font-small blue-grey lighten-5">
                <?php include("includes/footer.php");?>
            </footer>
            <div  style="height: 10px; background: #27AAE1"></div>
    </body>
</html>