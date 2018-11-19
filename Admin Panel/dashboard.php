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
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-2">
                    <div style="margin-top: 1cm;">
                        <img width="40" style="margin-right: 4px;" height="40" src="../images/user.png" class="img-responsive img-circle pull-left">
                        <h3 style="margin-top: 1cm; color: white;"><?php echo $_SESSION['username'];?></h3>
                    </div>

                    <ul style="margin-top: 1cm;" id="side_menu"  class="pull-left nav nav-pills nav-stacked">
                        <li class="active nav-item" ><a  href="dashboard.php"><span  class="fa fa-th"></span>&nbsp; Dashboard</a></li>
                        <hr class="my-1"/>
                        <li class="nav-item"><a href="add_new_post.php"><span  class="fa fa-list-alt"></span>&nbsp; Add New Post</a></li>
                        <li class="nav-item"><a href="categories.php"><span  class="fa fa-tags"></span>&nbsp; Categories</a></li>
                        <li class="nav-item"><a href="admins.php"><span  class="fa fa-user"></span>&nbsp; Manage Admin</a></li>
                        <li class="nav-item">
                            <a href="view_comments.php"><span  class="fa fa-comment">
                                </span>&nbsp; Comments<span class="btn-warning count pull-right"><?php if (!count_comment() <= 0){    echo count_comment();}?></span>
                            </a>
                        </li>
                        <li class="nav-item"><a href="../blog.php?Page=0"><span  class="fa fa-globe"></span>&nbsp; Live Blog</a></li>
                        <li class="nav-item"><a href="logout.php"><span  class="fa fa-door-open"></span>&nbsp; Logout</a></li>
                    </ul>
                </div><!-- End of Side Area -->
                <div  class="col-sm-10"><!-- Main Area -->
                    <div>
                        <?php echo error_message();
                        echo success_message();
                        // echo $_SESSION['query'];//."<br>".$_SESSION['edit'];

                        ?>
                    </div>
                    <h4 class="tableHeading">Admin Dashboard</h4>
                    <div class="table-responsive">
                        <table  class="table  table-striped table-hover">
                            <tr>
                                <th>No</th>
                                <th>Post Title</th>
                                <th>Date</th>
                                <th>Author</th>
                                <th>Category</th>
                                <th >Image</th>
                                <th>Comments</th>
                                <th>Action</th>
                                <th>Details</th>
                            </tr>
                            <?php
                            $view_query = "SELECT * FROM admin_panel ORDER BY date_time desc";
                            $execute = mysqli_query($con,$view_query);
                            $index = 0;
                            while ($rows = mysqli_fetch_array($execute)) {
                                # code...
                                $post_title = $rows['title'];
                                $category = $rows['category'];
                                $author = $rows['author'];
                                $date = $rows['date_time'];
                                $post = $rows['post'];
                                $id = $rows['id'];
                                $image = $rows['img'];
                                $index++;
                                ?>
                                <tr>
                                    <td><?php echo $index;?></td>
                                    <td><?php if (strlen($post_title) > 20) {
                                            # code...
                                            $post_title = substr($post_title,0,19)."...";
                                        } echo $post_title;?></td>
                                    <td><?php
                                        // if (strlen($date) > 11) {
                                        //     $date = substr($date,0,10);
                                        // }
                                        echo $date;?></td>
                                    <td><?php echo $author;?></td>
                                    <td><?php echo $category;?></td>
                                    <td><img style="max-height: 70px; max-width: 150px;" width="100" height="40" class="img-responsive" src="../uploads/<?php echo $image;?>" alt=""></td>
                                    <td>
                                <span class="btn-success count" style="margin: 15px">
                                    <?php
                                    $cons = mysqli_connect("localhost", "root", "", "void_io");

                                    $Approved= "SELECT COUNT(*) FROM comments WHERE post_id='$id' AND status = 'approved'";
                                    $ex = mysqli_query($cons, $Approved);

                                    $ro  = mysqli_fetch_array($ex);
                                    $tol = array_shift($ro);
                                    echo $tol;
                                    ?>
                                </span>
                                        <span class="btn-danger count" style="margin: 15px;">
                                    <?php
                                    $conx = mysqli_connect("localhost", "root", "", "void_io");
                                    $Approvedcomment = "SELECT COUNT(*) FROM comments WHERE post_id='$id' AND status = 'pending'";
                                    $exx = mysqli_query($conx, $Approvedcomment);

                                    $row= mysqli_fetch_array($exx);
                                    $total = array_shift($row);
                                    echo $total;
                                    ?>
                                </span>

                                    </td>
                                    <td>
                                        <a href="edit_post.php?edit=<?php echo $id;?>"> <span class="btn btn-outline-warning btn-sm"><i class="fa fa-edit"></i></span></a>
                                        <a href="delete_post.php?delete=<?php echo $id;?>"><span class="btn btn-outline-danger btn-sm" ><i class=" fa fa-trash"></i></span></a>
                                    </td>
                                    <td>
                                        <a href="../fullpost.php?id=<?php echo $id;?>&post_name=<?php echo $post_title;?>" target="_blank"><span class="btn btn-outline custom-btn btn-sm "><i class="fa fa-globe"></i></span> </a></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div><!-- End of Main Area -->
            </div><!-- End of Row -->
        </div><!-- End container-fluid -->
    </main>

        <footer class="panel-footer footer font-small--blue lighten-5">
        <?php include("../includes/footer.php");?>
    </footer>
<!--    <div  style="height: 10px; background: #27AAE1"></div>-->
    </body>
</html>