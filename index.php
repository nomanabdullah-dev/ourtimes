<?php

    include "inc/header.php";
    $no_of_posts_per_page = 3;
    $start = 0;
    $end = 0;
?>

        <section id="cta" class="section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-12 align-self-center">
                        <h2>A digital marketing blog</h2>
                        <p class="lead"> Aenean ut hendrerit nibh. Duis non nibh id tortor consequat cursus at mattis felis. Praesent sed lectus et neque auctor dapibus in non velit. Donec faucibus odio semper risus rhoncus rutrum. Integer et ornare mauris.</p>
                        <a href="#" class="btn btn-primary">Try for free</a>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="newsletter-widget text-center align-self-center">
                            <h3>Subscribe Today!</h3>
                            <p>Subscribe to our weekly Newsletter and receive updates via email.</p>
                            <form class="form-inline" method="post">
                                <input type="text" name="email" placeholder="Add your email here.." required class="form-control" />
                                <input type="submit" value="Subscribe" class="btn btn-default btn-block" />
                            </form>         
                        </div><!-- end newsletter -->
                    </div>
                </div>
            </div>
        </section>

        <section class="section lb">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                        <div class="page-wrapper">
                            <div class="blog-custom-build">

                                <?php
                                if (isset($_GET['page'])) {
                                    $page_no = $_GET['page'];
                                    if ($page_no == 1) {
                                        $start = 0;
                                        $end = 0;
                                        $query = "SELECT * FROM wp_posts ORDER BY p_id DESC LIMIT $start,$no_of_posts_per_page";
                                    }elseif ($page_no>1) {
                                        $start = ($page_no-1)*$no_of_posts_per_page;
                                        // $end = $start+$no_of_posts_per_page;
                                        $query = "SELECT * FROM wp_posts ORDER BY p_id DESC LIMIT $start,$no_of_posts_per_page";
                                    }
                                
                                }else {
                                    $query = "SELECT * FROM wp_posts ORDER BY p_id DESC LIMIT $no_of_posts_per_page";
                                }
                                    $result = mysqli_query($db,$query);
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
                                    
                                    <?php
                                    $sql = "SELECT * FROM wp_posts";
                                    $result = mysqli_query($db, $sql);
                                    $total_posts = mysqli_num_rows($result);

                                    if ($total_posts%$no_of_posts_per_page == 0) {
                                        $total_page = $total_posts/$no_of_posts_per_page;
                                    }else {
                                        $page_res = $total_posts/$no_of_posts_per_page;
                                        $total_page = intval($page_res)+1;
                                    }
                                    ?>

                                    <?php
                                    $navigator = 0;
                                    while ($total_page != 0) {
                                        $navigator++
                                        ?>
                                        <li class="page-item"><a class="page-link" href="index.php?page=<?= $navigator;?>"><?= $navigator;?></a></li>
                                        <?php
                                        $total_page--;
                                    }
                                    
                                    ?>
                                        <li class="page-item">
                                            <?php
                                            if (isset($_GET['page'])) {
                                                $page_no = $_GET['page'];
                                                $next = $page_no + 1;
                                                ?>
                                                <a class="page-link" href="index.php?page=<?= $next;?>">Next</a>
                                                <?php
                                            }else {
                                                ?>
                                                <a class="page-link" href="index.php?page=2">Next</a>
                                                <?php
                                            }
                                            ?>
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


<?php

    include "inc/footer.php";

?>