<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Void.io</title>
    <?php include("includes/head.php");
        require_once("includes/db.php");
    ?>
    <link rel="stylesheet" href="css/publicstyles.css">
</head>
<body>
    
<!--    <a href="dashboard.php">..d</a>-->
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

    <div class="container-fluid" style="margin-top: 2.5cm;"><!--Container-->
        <div class="blog-header">
<!--            <h1>Blog Posts</h1>
            <p class="lead">My First Blog post, Hello Blog you were created using PHP. :)</p>-->
        </div>

        <div style="margin-top: 15px;" class="row"><!--Row -->
            <div class="col-lg-8 col-sm-8"><!--Main Area -->
                <?php
                    $conn = mysqli_connect("localhost","root","","void_io");
                    $view_query = "";
                    $catt = filter_input(INPUT_GET, "category");
                    $sb = filter_input(INPUT_GET, "searchButton");
                    $pagg = filter_input(INPUT_GET, "Page");
                    if (isset($sb)) {
                        # code...
                        $search= filter_input(INPUT_GET, "search");
                        //Query for search
                        $view_query = "SELECT * FROM admin_panel WHERE date_time LIKE '%$search%'
                        OR title LIKE '%$search%' OR category LIKE '%$search%' OR post LIKE '%$search%'";
                        
                        }
                        elseif (isset ($catt)) {
                            $cat  = filter_input(INPUT_GET, 'category');
                            $view_query = "SELECT * FROM admin_panel WHERE category = '$cat' ORDER BY date_time desc";
                        }
                        elseif (isset ($pagg)) {
                            //Pagination
                            $page = filter_input(INPUT_GET, "Page");
                            
                            
                            $conx = mysqli_connect("localhost","root","","void_io");
                            $numberofposts = "SELECT COUNT(*) FROM admin_panel";
                                        $exx = mysqli_query($conx, $numberofposts);
                                    
                                        $rows = mysqli_fetch_array($exx);
                                        $total = array_shift($rows);
                            
                            if($page <= 0 || $page >= $total-3){
                                
                                $show = 0;
                            }else{
                                $show = ($page*3)-3;
                            }
                            //mysqli_close($conx);
                            $view_query = "SELECT * FROM admin_panel ORDER BY date_time desc  LIMIT $show,3";
                        }
                       // echo $total;
                            
                        else {
                            //Defualt Blog query
                        $view_query  = "SELECT * FROM admin_panel ORDER BY date_time desc  LIMIT 0,3";}
                        $execute = mysqli_query($conn,$view_query);
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
                    <div class="blogpost card mb-3 mt-3">
                        <div class="view overlay zoom">
                            <img style="max-height: 15cm;" class="img-fluid card-img-top" src="uploads/<?php echo $image;?>" alt="image">
                            <div class="mask flex-center waves-effect rgba-white-slight"></div>
                        </div>

                        <div class="card-body p-2">
                            <div class="caption card-title"><h2 id="heading"><?php echo htmlentities($title);?></h2></div>
                            <p class="description card-text">Category: <?php echo htmlentities($category); ?>
                                Published On: <?php echo htmlentities($date);?>
                            </p>
                            <hr class="my-3"/>
                            <p class="post card-text"><?php
                                if(strlen($post_content) > 400){
                                    $post_content = substr($post_content,0,400)."...";
                                }
                                echo htmlentities($post_content);
                                ?></p>
                            <a href="fullpost.php?id=<?php echo $post_id;?>&post_name=<?php echo $title;?>">
                                <span class="btn btn-info" style="background-color: #cc0099; border-color:#cc0099; ">Read More &rsaquo; &rsaquo;</span>
                            </a>
                        </div>



                    </div>
                <?php  }
                    }else {?>
                    <div class="thumbnail alert alert-danger"><h1>NO Result Found</h1></div>

                    <?php } mysqli_close($conn);?>
                     <nav>
                        <ul class="pagination pull-left pagination-sm">
                         <!--Creating backward button -->    
                    <?php
                    if(isset($page)){
                        if ($page>1){
                    ?>
                            <li class=" btn-primary"><a href="blog.php?Page=<?php echo$page-1; ?>">&laquo;</a></li>
                         <?php }} ?> 
                            <!--end backward button --> 
                            <!--pagination --> 
                    <?php 
                        $postCon = mysqli_connect("localhost","root","","void_io");
                        $totalPost = "SELECT COUNT(*) FROM admin_panel";
                        $exec = mysqli_query($postCon, $totalPost);
                        $rowss = mysqli_fetch_array($exec);
                        $totalNum = array_shift($rowss);
                        
                        $TpostPerPage = $totalNum/3;
                        $postPerPage = ceil($TpostPerPage);
                        
                        for ($i = 1; $i <= $postPerPage; $i++){
                            if(isset($page)) {
                            if($i==$page){
                    ?>
                   
                            <li class="active"><a href="blog.php?Page=<?php echo $i;?>"><?php echo $i;?></a></li>
                        
                        <?php } else {?>
                                <li><a href="blog.php?Page=<?php echo $i;?>"><?php echo $i;?></a></li>
                           <?php }} 
                        
                        }?>
                        <!--End Pagination --> 
                        
                    <!--Creating forward button -->            
                    <?php
                    if(isset($page)){
                        if ($page+1 <= $postPerPage ){
                    ?>
                                <li class=" btn-primary"><a href="blog.php?Page=<?php echo$page-1; ?>">&raquo;</a></li>
                         <?php }} mysqli_close($postCon); ?> 
                                <!--End forward button --> 
                    </ul>
                     </nav>
            </div><!--End of Main Area -->
            
            <!-- Side Area -->
            <div class="col-lg-3 col-sm-3 mb-3">
                <?php include_once 'includes/side_area.php';?>
            </div><!--End of Side Area -->
            
            
        </div><!--End of Row -->
</div><!--End of Container -->
<!--page footer--> 
    <footer class="panel-footer footer font-small--blue lighten-5">
        <?php include("includes/footer.php");
         mysqli_close($con);?>
    </footer>
<!--end page footer --> 
    <div  style="height: 10px; background: #27AAE1"></div>
</body>
</html>