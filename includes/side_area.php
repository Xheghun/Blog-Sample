  <div class="card p-3">
      <h2 id="header" class="text-center">MFM</h2>
      <img src="images/logo.png" class=" imageicon img-responsive img-circle" />
      <p id="content">
          TrueType is a font standard developed in the late 1980s, by Apple and Microsoft.
          TrueType is the most common font format for both the Mac OS and Microsoft Windows operating systems.OpenType Fonts (OTF)
          OpenType is a format for scalable computer fonts. It was built on TrueType, and is a registered trademark of Microsoft.
          OpenType fonts are used commonly today on the major computer platforms.
      </p>
      <div class="panel panel-primary">

          <div class="panel-heading" style="background-color: #cc0099;">
              <h2 class="panel-title"> Categories</h2>
          </div>
          <div class="panel-body">
              <?php
              $coNect = mysqli_connect("localhost","root","","void_io");
              $qq = "SELECT * FROM category";
              $ee = mysqli_query($coNect, $qq);
              if($ee){
                  while($roWS = mysqli_fetch_assoc($ee)){
                      $name = $roWS['c_name'];
                      ?>
                      <a href="blog.php?category=<?php echo $name;?>"
                      <span><?php echo ucwords($name).'<br>'; ?></span></a>
                      <?php
                  }
              }
              mysqli_close($coNect);
              ?>
          </div>
          <div class="panel-footer">

          </div>
      </div>

      <div class="panel panel-primary">

          <div class="panel-heading" style="background-color: #cc0099;">
              <h2 class="panel-title"> Recent Posts</h2>
          </div>
          <div class="panel-body">
              <?php
              $myconn = mysqli_connect("localhost", "root", "", "void_io");
              $rPosts = "SELECT * FROM admin_panel ORDER BY date_time LIMIT 0,4";
              $r_execute = mysqli_query($myconn, $rPosts);
              if($r_execute){
                  //fetch posts
                  while ($r_rows = mysqli_fetch_assoc($r_execute)){
                      $rid = $r_rows['id'];
                      $rtitle  = $r_rows['title'];
                      $rdate = $r_rows['date_time'];
                      $rCategory  = $r_rows['category'];
                      $rimage = $r_rows['img'];
                      ?>
                      <div class="">
                          <img src="uploads/<?php echo $rimage;?>" width="80px" height="100" style="margin-right: 5px;" class="img-responsive pull-left"/>
                          <a href="fullpost.php?id=<?php echo $rid;?>&post_name=<?php echo $rtitle;?>"><h4><?php echo $rtitle;?></h4></a>
                          Category: <?php echo $rCategory;?><br>
                          <?php echo $rdate;?>
                      </div>
                      <hr/>
                      <?php
                  }
              }
              mysqli_close($myconn);
              ?>
          </div>
          <div class="panel-footer">

          </div>
      </div>
  </div>
