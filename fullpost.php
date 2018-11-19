<DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title><?php echo filter_input(INPUT_GET, "post_name");?></title>

        <?php
        include("includes/head.php");
        require_once("includes/db.php");
        require_once("includes/functions.php");
        require_once("includes/sessions.php");
        include_once 'includes/handle_comment.php';
        ?>
        <link rel="stylesheet" href="css/publicstyles.css">
    </head>
    <body>
        <div style="height: 10px; background: #cc0099;"></div>
        <nav class="navbar navbar-expand-lg navbar-dark stylish-color-dark indigo fixed-top">
            <div class="container">
                <!-- Navbar brand -->
                <a class="navbar-brand" href="blog.php?Page=0"><img class="img-circle img-responsive" style="margin-top: 10px" width="50" height="50" src="images/logo.png"/></a>
                <!-- Collapse button -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav" aria-controls="basicExampleNav"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Collapsible content -->
                <div class="collapse navbar-collapse show" id="basicExampleNav">
                    <!-- Links -->
                    <ul class="navbar-nav mr-auto smooth-scroll">
                        <li class="nav-item active">
                            <a class="nav-link" href="blog.php?Page=0">Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Service
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="Admin%20Panel/login.php">Login</a>
                        </li>
                    </ul>
                    <form action="blog.php" method="get" class="form-inline">
                        <div class="md-form mt-0">
                            <input type="text" class="form-control mr-sm-2" aria-label="Search" placeholder="Search" name="search"/>
                            <button type="submit" class="btn btn-defualt btn-sm" value="query" name="searchButton"><span class="fa fa-search"></span></button>
                        </div>
                    </form>
                    <ul class="navbar-nav mr-auto mt-auto">
                        <li class="nav-item">
                        </li>
                    </ul>
                    <!-- Links -->
                </div>
                <!-- Collapsible content -->
            </div>
        </nav>

        <div class="line" style="height: 10px; background: #cc0099;"></div>
        <div class="container" style="margin-top: 3.5cm;"><!--Container-->
            <div class="row"><!--Row -->
                <div class="col-sm-8"><!--Main Area -->
                    <?php
                    $conn = mysqli_connect("localhost", "root", "", "void_io");
                    $view_query = "";
                    $sb = filter_input(INPUT_GET, "searchButton");
                    if (isset($sb)) {
                        # code...
                        $search =  filter_input(INPUT_GET, "search");
                        $view_query = "SELECT * FROM admin_panel WHERE date_time LIKE '%$search%'
                        OR title LIKE '%$search%' OR category LIKE '%$search%' OR post LIKE '%$search%'";
                    } else {
                        $post_id_from_url = filter_input(INPUT_GET, "id");
                        $view_query = "SELECT * FROM admin_panel WHERE id = '$post_id_from_url' ORDER BY date_time desc";
                    }
                    $execute = mysqli_query($conn, $view_query);
                    if ($execute) {
                        # code...
                        while ($rows = mysqli_fetch_array($execute)) {
                            # code...
                            $post_id = $rows['id'];
                            $date = $rows["date_time"];
                            $title = $rows["title"];
                            $category = $rows["category"];
                            $author = $rows["author"];
                            $image = $rows["img"];
                            $post_content = $rows["post"];
                            ?>
                            <div class="blogpost card">
                                <div class="view overlay zoom">
                                    <img class="img-fluid card-img-top" style="max-height: 15cm;" src="uploads/<?php echo $image; ?>" alt="<h1>image</h1>">
                                    <div class="mask waves-effect rgba-white-slight"></div>
                                </div>
                            </div>
                                <div class="mt-3">
                                    <div class="caption card-title"><h2 id="heading"><?php echo htmlentities($title); ?></h2></div>
                                    <p class="description">Category: <?php echo htmlentities($category); ?>
                                        Published On: <?php echo htmlentities($date); ?>
                                    </p>
                                    <p class="post"><?php
                                        echo nl2br($post_content);
                                        ?></p>
                                </div>
                        <?php }
                     }//mysqli_close($conn);
                    ?>
                    <br><br>
                    <div>
                        <h5 class="tableHeading">Comments</h5>
                        <?php
                        $post_id = filter_input(INPUT_GET, "id");
                        $con_db = mysqli_connect("localhost", "root", "", "void_io");
                        $extract_query = "SELECT * FROM comments WHERE post_id = '$post_id' AND status='approved'";
                        $exe_cute = mysqli_query($con_db, $extract_query);
                        while ($rows = mysqli_fetch_array($exe_cute)) {
                            $date = $rows["date_time"];
                            $name = $rows["name"];
                            $comment = $rows["comment"];
                            ?>
                            <div class="comment-block">
                                <img style="margin-right: 15px;" src="images/user.png" width="80px;" height="70px;" class="img-responsive img-rounded pull-left" />
                                <p class="comment-info"><?php echo ucwords($name); ?></p>
                                <p class="description"><?php echo $date; ?></p>
                                <p  class="comment"><?php echo $comment; ?></p>
                            </div>

                            <hr/>
                        <?php if ($rows == null) {
                          //mysqli_close($con_db);?>
                        <h2>No Comments Yet.</h2>
                        <?php }}?>

                    </div>

                </div><!--End of Main Area -->
                <!-- Side Area -->
                <div class="col-sm-offset-0 col-sm-4">
                    <form action="fullpost.php?id=<?php echo filter_input(INPUT_GET, "id");?>&post_name=<?php echo filter_input(INPUT_GET, "post_name"); ?>" method="post" enctype="multipart/form-data">
                        <fieldset>
                            <caption><h3 class="tableHeading" style="width: 100%;"> Share your thoughts</h3></caption>
                            <?php
                            echo success_message();
                            echo error_message();
                            echo pending_message();
                            ?>
                            <div class="form-group">
                                <label for="title"><span class="fieldInfo">Name:</span></label>
                                <input  class="form-control" placeholder="Name" type="text" id="name" name="name">
                            </div>
                            <div class="form-group">
                                <label for="email" ><span class="fieldInfo"> Email:</span></label>
                                <input type="email" class="form-control" name="email" id="email"/>
                            </div>
                            <div class="form-group">
                                <label for="post" class="fieldInfo">Comment:</label>
                                <textarea name="comment" id="comment" class="form-control" cols="30" rows="10" placeholder="Comment"></textarea>
                            </div>
                            <button style="margin-bottom:10px; background-color: #cc0099; border-color: #cc0099;" class="btn btn-info btn-md"  type="submit" name="submit_comment" value="Send"><span class="fa fa-send"></span></button>
                        </fieldset>
                    </form>
                    <hr/>

                    <div class="mb-3">
                        <?php include_once 'includes/side_area.php';?>
                    </div>

            
                    
                </div><!--End of Side Area -->
            </div><!--End of Row -->
        </div><!--End of Container -->
        <footer class="panel-footer footer font-small--blue lighten-5">
            <?php include("includes/footer.php");  //mysqli_close($con);?>
        </footer>
        <div  style="height: 10px; background: #27AAE1"></div>
    </body>
</html>