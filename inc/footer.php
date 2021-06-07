<footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                        <div class="widget">
                            <h2 class="widget-title">Recent Posts</h2>
                            <div class="blog-list-widget">
                                <div class="list-group">
                                <?php
                                            $query = "SELECT * FROM wp_posts WHERE p_status = 1 ORDER BY p_id DESC LIMIT 3";
                                            $result = mysqli_query($db,$query);
                                            $count= 0;
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $p_id       = $row['p_id'];
                                                $thumbnail  = $row['thumbnail'];
                                                $p_title    = $row['p_title'];
                                                $p_desc     = $row['p_desc'];
                                                $p_date     = $row['p_date'];
                                                $cat_id     = $row['cat_id'];
                                                $author_id  = $row['author_id'];
                                                $comment_id = $row['comment_id'];
                                                $p_status   = $row['p_status'];
                                            ?>
                                            <a href="single.php?post_id=<?= $p_id;?>" class="list-group-item list-group-item-action flex-column align-items-start">
                                                <div class="w-100 last-item justify-content-between">
                                                    <img src="wp-admin/assets/img/posts/<?php echo $thumbnail;?>" alt="" class="img-fluid float-left">
                                                    <h5 class="mb-1"><?php echo $p_title;?></h5>
                                                    <small><?php echo $p_date;?></small>
                                                </div>
                                            </a>
                                            <?php
                                            }
                                        ?>
                                </div>
                            </div><!-- end blog-list -->
                        </div><!-- end widget -->
                    </div><!-- end col -->

                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                        <div class="widget">
                            <h2 class="widget-title">Popular Posts</h2>
                            <div class="blog-list-widget">
                                <div class="list-group">
                                    <a href="marketing-single.html" class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="w-100 justify-content-between">
                                            <img src="upload/small_01.jpg" alt="" class="img-fluid float-left">
                                            <h5 class="mb-1">Banana-chip chocolate cake recipe with customs</h5>
                                            <span class="rating">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </span>
                                        </div>
                                    </a>

                                    <a href="marketing-single.html" class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="w-100 justify-content-between">
                                            <img src="upload/small_02.jpg" alt="" class="img-fluid float-left">
                                            <h5 class="mb-1">10 practical ways to choose organic vegetables</h5>
                                            <span class="rating">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </span>
                                        </div>
                                    </a>

                                    <a href="marketing-single.html" class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="w-100 last-item justify-content-between">
                                            <img src="upload/small_03.jpg" alt="" class="img-fluid float-left">
                                            <h5 class="mb-1">We are making homemade ravioli, nice and good</h5>
                                            <span class="rating">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            </div><!-- end blog-list -->
                        </div><!-- end widget -->
                    </div><!-- end col -->

                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                        <div class="widget">
                            <h2 class="widget-title">Popular Categories</h2>
                            <div class="link-widget">
                                <ul>
                                <?php
                                        $query = "SELECT * FROM wp_category ORDER BY c_name ASC";
                                        $result = mysqli_query($db,$query);
                                        while($row = mysqli_fetch_assoc($result)){
                                        $c_id     = $row['c_id'];
                                        $c_name   = $row['c_name'];
                                        $c_desc   = $row['c_desc'];

                                        // count num of posts
                                        $sql = "SELECT * FROM wp_posts WHERE cat_id ='$c_id'";
                                        $result2 = mysqli_query($db, $sql);
                                        $count = mysqli_num_rows($result2);

                                        ?>
                                            <li><a href="archive.php?category_id=<?= $c_id;?>"><?php echo $c_name;?><span>(<?php echo $count;?>)</span></a></li>
                                        <?php

                                        }
                                    ?>
                                </ul>
                            </div><!-- end link-widget -->
                        </div><!-- end widget -->
                    </div><!-- end col -->
                </div><!-- end row -->

                <div class="row">
                    <div class="col-md-12 text-center">
                        <br>
                        <br>
                        <div class="copyright">&copy; Markedia. Design: <a href="http://html.design">HTML Design</a>.</div>
                    </div>
                </div>
            </div><!-- end container -->
        </footer><!-- end footer -->

        <div class="dmtop">Scroll to Top</div>
        
    </div><!-- end wrapper -->

    <!-- Core JavaScript
    ================================================== -->
    <script src="js/jquery.min.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/animate.js"></script>
    <script src="js/custom.js"></script>

</body>
</html>