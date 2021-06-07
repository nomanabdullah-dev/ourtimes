<?php
  include "includes/header.php";
?>

      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          
        <?php
        
        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

        // view user
        if($do == 'Manage'){
        ?>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Serial</th>
                            <th>Date</th>
                            <th>Thumbnail</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Action</th>
                            
                        </tr>
                    </thead>
                    <tbody>

                    <?php
                        $query = "SELECT * FROM wp_posts";
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
                            $count++;
                            ?>

                            <tr>
                                <td><?php echo $count;?></td>
                                <td><?php echo $p_date;?></td>
                                <td>
                                    <img src="assets/img/posts/<?php echo $thumbnail; ?>" width="100px">
                                </td>
                                <td><?php echo $p_title;?></td>
                                <td><?php echo $p_desc;?></td>
                                <td>
                                    <?php
                                    $cat_name = "SELECT c_name FROM wp_category WHERE c_id='$cat_id'";
                                    $cat_result = mysqli_query($db, $cat_name);
                                    while ($row = mysqli_fetch_assoc($cat_result)) {
                                        $category = $row['c_name'];
                                    }
                                    echo $category;
                                    ?>
                                </td>
                                <td>
                                <?php
                                    $author_name = "SELECT u_name FROM wp_users WHERE u_id='$author_id'";
                                    $result2 = mysqli_query($db, $author_name);
                                    while ($row = mysqli_fetch_assoc($result2)) {
                                        $author = $row['u_name'];
                                    }
                                    echo $author;
                                ?>
                                </td>
                                <td>
                                    <?php
                                    if ($p_status == 0) {
                                        echo '<div class="badge badge-danger">Pending</div';
                                    }else if ($p_status == 1) {
                                        echo '<div class="badge badge-success">Approved</div';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="posts.php?do=edit&edit_id=<?php echo $p_id;?>">
                                        <button type="button" class="btn btn-success btn-sm">Edit</button>
                                    </a>
                                    <a>
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#<?php echo $p_id;?>">Delete</button>
                                    </a>
                                        <!-- Modal -->
                                        <div id="<?php echo $p_id;?>" class="modal fade" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                            <div class="modal-body text-center">
                                                <h5 style="text-style:bold">Are you sure to delete?</h5>
                                                <a href="posts.php?do=delete&post_id=<?php echo $p_id;?>">
                                                    <center class="btn btn-md btn-danger" style="margin-right:10px">Yes</center>
                                                </a>
                                                <center class="btn btn-md btn-primary" data-dismiss="modal" style="margin-left:10px">No</center>
                                            </div>
                                            </div>

                                        </div>
                                        </div>
                                </td>
                                
                            </tr>
                            
                            <?php

                        }
                    ?>
                        
                    </tbody>
                </table>

            </div>
        </div>
        <?php
        }
        //add user
        else if($do == 'add'){
            ?>
            <div class="card">
                <div class="card-header">
                    <h1>Add New Post</h1>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <input type="text" placeholder="Enter post title" name="post_title" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Enter your post description</label>
                                    <textarea name="post_desc" class="form-control" rows="15">
                                    </textarea>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <select name="post_cat" class="form-control">
                                        <option>Please select a Category</option>
                                        <?php
                                        $query = "SELECT * FROM wp_category";
                                        $result = mysqli_query($db,$query);
                                        while($row = mysqli_fetch_assoc($result)){
                                          $c_id     = $row['c_id'];
                                          $c_name   = $row['c_name'];
                                          $c_desc   = $row['c_desc'];
                                        ?>
                                        <option value="<?php echo $c_id;?>"><?php echo $c_name;?></option>
                                        <?php
                                        }
                                        ?>
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div>
                                    <input type="file" name="image">
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="add_post" class="btn btn-md btn-info" value="Add New Post">
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php
                    if(isset($_POST['add_post'])){
                        
                        $post_title  = $_POST['post_title'];
                        $post_desc   = $_POST['post_desc'];
                        $post_cat    = $_POST['post_cat'];
                        $image_name  = $_FILES['image']['name'];
                        $tmp_name    = $_FILES['image']['tmp_name'];

                        if (empty($post_title) || empty($post_desc) || empty($post_cat) || empty($image_name)) {
                            echo '<div class="alert alert-danger">Please insert all the info</div>';
                        }else {
                            // array of img file type
                            $extensions = array('jpg','jpeg','png');
                            //split the file name
                            $extn = strtolower(end(explode('.', $_FILES['image']['name'])));
                            if (in_array($extn,$extensions) === false) {
                                echo '<div class="alert alert-danger">Please insert an image (jpg, jpeg, png) !</div>';
                            }else {
                                $random = rand();
                                $updateName = $random.'_'.$image_name;
                                move_uploaded_file($tmp_name, "assets/img/posts/".$updateName);

                                $sql5 = "INSERT INTO wp_posts(thumbnail,p_title,p_desc,p_date,cat_id,author_id,p_status) VALUES('$updateName', '$post_title', '$post_desc', now(), '$post_cat', '12', 0)";
                                $result5 = mysqli_query($db, $sql5);
                                if ($result5) {
                                    header('Location: posts.php');
                                }else{
                                    die("Insert new post error!".mysqli_error($db));
                                }
                            }
                        }

                    }
                    ?>
                </div>
            </div>
            <?php
        }
        //edit user
        else if($do == 'edit'){
            if (isset($_GET['edit_id'])) {
                $edit_post_id = $_GET['edit_id'];

                $query = "SELECT * FROM wp_posts WHERE P_id='$edit_post_id'";
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
                }
                ?>
                <div class="card">
                    <div class="card-header">
                        <h1>Edit Post</h1>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="posts.php?do=update" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <input type="text" value="<?php echo $p_title;?>" name="post_title" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Enter your post description</label>
                                        <textarea name="post_desc" class="form-control" rows="15" value="<?php echo $p_desc;?>"><?php echo $p_desc;?>
                                        </textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <select name="post_cat" class="form-control">
                                            <option>Please select a Category</option>
                                            <?php
                                            $query = "SELECT * FROM wp_category";
                                            $result = mysqli_query($db,$query);
                                            while($row = mysqli_fetch_assoc($result)){
                                            $c_id     = $row['c_id'];
                                            $c_name   = $row['c_name'];
                                            $c_desc   = $row['c_desc'];
                                            ?>
                                            <option value="<?php echo $c_id;?>"
                                                <?php
                                                    if ($c_id == $cat_id) {
                                                        echo 'selected';
                                                    }
                                                ?>
                                            ><?php echo $c_name;?></option>
                                            <?php
                                            }
                                            ?>
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <div>
                                        <input type="hidden" name="old_img" value="<?php echo $thumbnail;?>">
                                        <img src="assets/img/posts/<?php echo $thumbnail;?>" width="200px"> <br><br>
                                        <input type="file" name="image">
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control" name="status">
                                            <option value="1" <?php
                                                if ($p_status == 1) {
                                                    echo 'Selected';
                                                }
                                            ?>>Active</option>
                                            <option value="0" <?php
                                                if ($p_status == 0) {
                                                    echo 'Selected';
                                                }
                                            ?>>Pending</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="post_id" value="<?php echo $p_id;?>">
                                        <input type="submit" name="edit_post" class="btn btn-md btn-info" value="Edit Post">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
            }
        }
        //update user
        else if($do == 'update'){
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $post_id     = $_POST['post_id'];
                $post_title  = $_POST['post_title'];
                $post_desc   = $_POST['post_desc'];
                $post_cat    = $_POST['post_cat'];
                $status      = $_POST['status'];
                $old_img     = $_POST['old_img'];
                $image_name  = $_FILES['image']['name'];
                $tmp_name    = $_FILES['image']['tmp_name'];
                
                if(empty($image_name)){
                   $upadate_query = "UPDATE wp_posts SET p_title='$post_title', p_desc='$post_desc', cat_id='$post_cat', p_status='$status' WHERE p_id='$post_id'";
                   $result6 = mysqli_query($db, $upadate_query);
                   if($result6){
                    header('Location: posts.php');
                    }else{
                    die("Update post error!".mysqli_error($db));
                    }
                }else{
                    // array of img file type
                    $extensions = array('jpg','jpeg','png');
                    //split the file name
                    $dot = explode('.', $_FILES['image']['name']);
                    $end_name = end($dot);
                    $extn = strtolower($end_name);
                    if(in_array($extn,$extensions) === false){
                        echo '<div class="alert alert-danger">Please insert an image (jpg, jpeg, png) !</div>';
                    }else{
                        $random = rand();
                        $updateName = $random.'_'.$image_name;
                        move_uploaded_file($tmp_name, "assets/img/posts/".$updateName);
                        //delete existing img
                        unlink('assets/img/posts/'.$old_img);

                        $upadate_query = "UPDATE wp_posts SET thumbnail='$updateName', p_title='$post_title', p_desc='$post_desc', cat_id='$post_cat', p_status='$status' WHERE p_id='$post_id'";
                        $result7 = mysqli_query($db,$upadate_query);
                        if ($result7) {
                        header('Location: posts.php');
                        }else{
                        die("Update post error!".mysqli_error($db));
                        }
                    }
                }
            }
        }
        //delete user
        else if($do == 'delete'){
            if (isset($_GET['post_id'])) {
                $table = 'wp_posts';
                $table_id = 'p_id';
                $delete_id = $_GET['post_id'];
                $page_url = 'posts.php';

                // //delete post img first
                $query10 = "SELECT thumbnail FROM wp_posts WHERE p_id='$delete_id'";
                $result10 = mysqli_query($db,$query10);
                while ($row = mysqli_fetch_assoc($result10)) {
                $delete_img = $row['thumbnail'];
                }
                unlink('assets/img/posts/'.$delete_img);

                delete($table,$table_id,$delete_id,$page_url);
            }
        }

        ?>


        </div>
      </div>


<?php    
include "includes/footer.php";     
?>