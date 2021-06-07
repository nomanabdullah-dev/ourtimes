<?php
    include "inc/header.php";
?>

<?php
if (isset($_GET['category_id'])) {
    $archive_id = $_GET['category_id'];
?>
    <section class="section lb">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                        <div class="page-wrapper">
                            <div class="blog-custom-build">

                                <?php
                                $query = "SELECT * FROM wp_posts WHERE cat_id='$archive_id'";
                                $result = mysqli_query($db,$query);
                                $post_count = mysqli_num_rows($result);
                                if ($post_count == 0) {
                                    echo "<br><br><br>No Post Found!";
                                }
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

                                <div class="blog-box wow fadeIn">
                                    <div class="post-media">
                                        <a href="single.php?post_id=<?= $p_id;?>" title="">
                                            <img src="wp-admin/assets/img/posts/<?= $thumbnail;?>" alt="" class="img-fluid">
                                            <div class="hovereffect">
                                                <span></span>
                                            </div>
                                            <!-- end hover -->
                                        </a>
                                    </div>
                                    <!-- end media -->
                                    <div class="blog-meta big-meta text-center">
                                        <!-- <div class="post-sharing">
                                            <ul class="list-inline">
                                                <li><a href="#" class="fb-button btn btn-primary"><i class="fa fa-facebook"></i> <span class="down-mobile">Share on Facebook</span></a></li>
                                                <li><a href="#" class="tw-button btn btn-primary"><i class="fa fa-twitter"></i> <span class="down-mobile">Tweet on Twitter</span></a></li>
                                                <li><a href="#" class="gp-button btn btn-primary"><i class="fa fa-google-plus"></i></a></li>
                                            </ul>
                                        </div>end post-sharing -->
                                        <h4><a href="single.php?post_id=<?= $p_id;?>" title=""><?= $p_title;?></a></h4>
                                        <p><?= substr($p_desc, 1, 200);?><a href="single.php?post_id=<?= $p_id;?>"> Read More...</a></p>
                                        <small><a href="marketing-category.html" title="">
                                            <?php
                                            $cat_name = "SELECT c_name FROM wp_category WHERE c_id='$cat_id'";
                                            $cat_result = mysqli_query($db, $cat_name);
                                            while ($row = mysqli_fetch_assoc($cat_result)) {
                                                $category = $row['c_name'];
                                            }
                                            echo $category;
                                            ?>
                                        </a></small>
                                        <small><a href="#" title=""><?= date('d-M-Y',strtotime($p_date));?></a></small>
                                        <small><a href="#" title="">by 
                                            <?php
                                                $author_name = "SELECT u_name FROM wp_users WHERE u_id='$author_id'";
                                                $result2 = mysqli_query($db, $author_name);
                                                while ($row = mysqli_fetch_assoc($result2)) {
                                                    $author = $row['u_name'];
                                                }
                                                echo $author;
                                            ?>
                                        </a></small>
                                        <small><a href="#" title=""><i class="fa fa-eye"></i> 2291</a></small>
                                    </div><!-- end meta -->
                                </div><!-- end blog-box -->

                                <hr class="invis">

                                    <?php
                                }
                                
                                ?>

                            </div>
                        </div>

                        <hr class="invis">

                        <div class="row">
                            <div class="col-md-12">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">Next</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div><!-- end col -->
                        </div><!-- end row -->
                    </div><!-- end col -->

                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                        <?php include "inc/sidebar.php";?>
                    </div><!-- end col -->
                </div><!-- end row -->
            </div><!-- end container -->
        </section>
    }
        <?php

}else {
    echo '<div class="test-center"><br><br><br><br><b><h3>No Post Found!</h3></b><br><br><br><br></div>';
}
?>

<?php
    include "inc/footer.php";
?>