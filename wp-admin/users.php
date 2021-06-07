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
        <div class="row">
            <div class="col-lg-12 col-md-12">
              <div class="card">
                <div class="card-header card-header-warning">
                  <h4 class="card-title">Employees Stats</h4>
                  <p class="card-category">New employees on 15th September, 2016</p>
                </div>
                <div class="card-body table-responsive">
                  <table class="table table-hover">
                    <thead class="text-warning">
                      <th>Serial</th>
                      <th>Photo</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Address</th>
                      <th>Phone</th>
                      <th>Biodata</th>
                      <th>Role</th>
                      <th>Action</th>
                    </thead>
                    <tbody>
                    <?php
                    $query = "SELECT * FROM wp_users";
                    $result = mysqli_query($db,$query);
                    $count = 0;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $u_id       = $row['u_id'];
                        $u_name     = $row['u_name'];
                        $u_mail     = $row['u_mail'];
                        $u_pass     = $row['u_pass'];
                        $u_address  = $row['u_address'];
                        $u_phone    = $row['u_phone'];
                        $biodata    = $row['biodata'];
                        $photo      = $row['photo'];
                        $user_role  = $row['user_role'];
                        $count++;
                    ?>
                    
                    <tr>
                        <td><?php echo $count;?></td>
                        <td>
                         <img src="assets/img/users/<?php echo $photo;?>" width="70px">
                        </td>
                        <td><?php echo $u_name;?></td>
                        <td><?php echo $u_mail;?></td>
                        <td><?php echo $u_address;?></td>
                        <td><?php echo $u_phone;?></td>
                        <td><?php echo substr($biodata, 0,30);?></td>
                        <td>
                            <?php
                            if($user_role == 1){
                                echo '<span class="badge badge-success">admin</span>';
                            }
                            if($user_role == 0){
                                echo '<span class="badge badge-danger">subscriber</span>';
                            }
                            if($user_role == 2){
                              echo '<span class="badge badge-info">editor</span>';
                          }
                        
                            ?>
                            </td>
                        <td>
                            <a href="users.php?do=edit&editId=<?php echo $u_id;?>" type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                                <i class="material-icons">edit</i>
                            </a>
                            <a href="users.php?do=delete&deleteId=<?php echo $u_id;?>" type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                                <i class="material-icons">close</i>
                            </a>
                        </td>
                      </tr>

                    <?php

                    }
                    ?>

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        <?php
        }



        //add user
        else if($do == 'add'){
            ?>
            <div class="card">
              <div class="card-header">
                <h2>Add a new user</h2>
              </div>
              <div class="card-body">
                <form method="POST" action="users.php?do=insert" enctype="multipart/form-data">
                  <div class="row">
                    <div class="col-lg-6 col-md-12">
                      <div class="form-group">
                        <input type="text" placeholder="Username" class="form-control" required="required" name="name">
                      </div>
                      <div class="form-group">
                        <input type="email" placeholder="Email" class="form-control" required="required" name="email">
                      </div>
                      <div class="form-group">
                        <input type="password" placeholder="Password" class="form-control" required="required" name="password">
                      </div>
                      <div class="form-group">
                        <input type="password" placeholder="Confirm Password" class="form-control" required="required" name="confirmPass">
                      </div>
                      <div class="form-group">
                        <input type="text" placeholder="Address" class="form-control" required="required" name="address">
                      </div>
                      <div class="form-group">
                        <input type="number" placeholder="Phone" class="form-control" required="required" name="phone">
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                      <div class="form-group">
                        <textarea class="form-control" required="required" rows="15" name="biodata">Biodata</textarea>
                      </div>
                      <div class="form-group">
                        <select class="form-group" name="role">
                          <option value="0">Subscriber</option>
                          <option value="2">Editor</option>
                          <option value="1">Administrator</option>
                        </select>
                      </div>
                      <input type="file" class="form-control" name="image">
                      
                      <input type="submit" class="btn btn-md btn-danger" value="Add New User" name="add_user">
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <?php
        }
        //insert user
        else if($do == 'insert'){
          if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name         = $_POST['name'];
            $email        = $_POST['email'];
            $password     = $_POST['password'];
            $confirmPass  = $_POST['confirmPass'];
            $address      = $_POST['address'];
            $phone        = $_POST['phone'];
            $biodata      = $_POST['biodata'];
            $role         = $_POST['role'];
            $file_name    = $_FILES['image']['name'];
            $file_tmp     = $_FILES['image']['tmp_name'];
            // $file_size    = $_FILES['image']['size'];

            
            // array of img file type
            $extensions = array('jpg','jpeg','png');
           
            if (empty($name) || empty($email) || empty($password) || empty($confirmPass) || empty($address) || empty($phone) || empty($biodata) || empty($file_name)) {
              echo '<div class="alert alert-danger">Please fill all the information</div>';
            }
            else{
              //insert into database

              //split the file name
              $extn = strtolower(end(explode('.', $_FILES['image']['name'])));
              
              if(in_array($extn,$extensions) === false){
                echo '<div class="alert alert-danger">Please insert an image (jpg, jpeg, png) !</div>';
              }

              //password matching
              if(($password == $confirmPass) && (in_array($extn,$extensions) === true)){
                //encrypt password
                $length = strlen($password);
                if ($length < 6) {
                  echo '<div class="alert alert-danger">Password should be more then 5 characters!</div>';
                }else{
                  $hassPassword = sha1($password);

                  $random = rand();
                  $updateName = $random.'_'.$file_name;
                  move_uploaded_file($file_tmp, "assets/img/users/".$updateName);

                  $insert_query = "INSERT INTO wp_users(u_name,u_mail,u_pass,u_address,u_phone,biodata,photo,user_role) VALUES('$name','$email','$hassPassword','$address','$phone','$biodata','$updateName','$role')";

                  echo $insert_query;

                  $insert_result = mysqli_query($db,$insert_query);
                  if ($insert_result) {
                    header('Location: users.php');
                  }else{
                    die("Insert new user error!".mysqli_error($db));
                  }
                
                }
              }else{
                echo '<div class="alert alert-danger">Password not matched</div>';
              }

            }

          }
        
        }
        //edit user
        else if($do == 'edit'){
          if (isset($_GET['editId'])) {
            $user_id = $_GET['editId'];
            //read all info from database
            $edit_user = "SELECT * FROM wp_users WHERE u_id = '$user_id'";
            $result5 = mysqli_query($db,$edit_user);
            while ($row = mysqli_fetch_assoc($result5)) {
              $u_id       = $row['u_id'];
              $u_name     = $row['u_name'];
              $u_mail     = $row['u_mail'];
              $u_pass     = $row['u_pass'];
              $u_address  = $row['u_address'];
              $u_phone    = $row['u_phone'];
              $biodata    = $row['biodata'];
              $photo      = $row['photo'];
              $user_role  = $row['user_role'];
            }
            //show each info into a form
            ?>
            <div class="card">
              <div class="card-header">
                <h2>Edit User Information</h2>
              </div>
              <div class="card-body">
                <form method="POST" action="users.php?do=update" enctype="multipart/form-data">
                  <div class="row">
                    <div class="col-lg-6 col-md-12">
                      <div class="form-group">
                        <label>User Name</label>
                        <input type="text" name="edit_name" value="<?php echo $u_name;?>" class="form-control">
                      </div>
                      <div class="form-group">
                        <label>User Email</label>
                        <input type="email" name="edit_email" value="<?php echo $u_mail;?>" class="form-control">
                      </div>
                      <div class="form-group">
                        <label>Set New Password</label>
                        <input type="password" name="edit_pass" class="form-control">
                      </div>
                      <div class="form-group">
                        <label>User Address</label>
                        <input type="text" name="edit_address" value="<?php echo $u_address;?>" class="form-control">
                      </div>
                      <div class="form-group">
                        <label>User Phone</label>
                        <input type="number" name="edit_number" value="<?php echo $u_phone;?>" class="form-control">
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                      <div class="form-group">
                        <label>User Biodata</label>
                        <textarea rows="5" name="edit_biodata" class="form-control" value="<?php echo $biodata;?>"><?php echo $biodata;?></textarea>
                      </div>
                      <div >
                        <img src="assets/img/users/<?php echo $photo;?>" width="200px"> <br>
                        <label>User Profile Picture</label>
                        <input type="file" name="image" class="form-control">
                        <input type="hidden" name="old_img" value="<?php echo $photo;?>">
                      </div>
                      
                      <div class="form-group">
                        <select name="edit_role" class="form-control">
                          <option value="0" <?php
                            if ($user_role == 0) {
                              echo 'selected';
                            }
                          ?>>Subscriber</option>
                          <option value="2" <?php
                            if ($user_role == 2) {
                              echo 'selected';
                            }
                          ?>>Editor</option>
                          <option value="1" <?php
                            if ($user_role == 1) {
                              echo 'selected';
                            }
                          ?>>Admin</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <input type="hidden" name="edit_user_id" value="<?php echo $user_id;?>">
                        <input type="submit" class="btn btn-md btn-danger" value="Edit User" name="edit_user">
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
            $updateID = $_POST['edit_user_id'];
            
            $edit_name    = $_POST['edit_name'];
            $edit_email   = $_POST['edit_email'];
            $edit_pass    = $_POST['edit_pass'];
            $edit_address = $_POST['edit_address'];
            $edit_number  = $_POST['edit_number'];
            $edit_biodata = $_POST['edit_biodata'];
            $edit_role    = $_POST['edit_role'];
            $old_img      = $_POST['old_img'];
            $edit_img     = $_FILES['image']['name'];
            $tmp_img      = $_FILES['image']['tmp_name'];
            
            //update info into database
            //point-01: user img and pass changed
            //point-02: user pass changed
            //point-03: user imgchanged
            //point-04: user img and pass not changed

            //let's think, user changed both pass and img
            if (!empty($edit_pass) && !empty($edit_img)) {
              // array of img file type
              $extensions = array('jpg','jpeg','png');
              //split the file name
              $extn = strtolower(end(explode('.', $_FILES['image']['name'])));
              if (in_array($extn,$extensions) === false) {
                echo '<div class="alert alert-danger">Please insert an image (jpg, jpeg, png) !</div>';
              }else{
                $hassPassword = sha1($edit_pass);

                $random = rand();
                $updateName = $random.'_'.$edit_img;
                //delete existing img
                unlink('assets/img/users/'.$old_img);


                //move new img
                move_uploaded_file($tmp_img, "assets/img/users/".$updateName);

                //3 step
                $update_query = "UPDATE wp_users SET u_name='$edit_name', u_mail='$edit_email', u_pass='$hassPassword', u_address='$edit_address', u_phone='$edit_number', biodata='$edit_biodata', photo='$updateName', user_role='$edit_role' WHERE u_id='$updateID'";
                $update_result = mysqli_query($db,$update_query);
                if ($update_result) {
                  header('Location: users.php');
                }else{
                  die("Update User error!".mysqli_error($db));
                }
              }
            }
            //let's think, user changed pass only
            else if (!empty($edit_pass) && empty($edit_img)) {
              $hassPassword = sha1($edit_pass);
              $update_query7 = "UPDATE wp_users SET u_name='$edit_name', u_mail='$edit_email', u_pass='$hassPassword', u_address='$edit_address', u_phone='$edit_number', biodata='$edit_biodata', user_role='$edit_role' WHERE u_id='$updateID'";
              $update_result7 = mysqli_query($db,$update_query7);
              if ($update_result7) {
                  header('Location: users.php');
                }else{
                  die("Update User error!".mysqli_error($db));
                }
            }
            //let's think, user changed img only
            else if (empty($edit_pass) && !empty($edit_img)) {
              // array of img file type
              $extensions = array('jpg','jpeg','png');
              //split the file name
              $extn = strtolower(end(explode('.', $_FILES['image']['name'])));
              if (in_array($extn,$extensions) === false) {
                echo '<div class="alert alert-danger">Please insert an image (jpg, jpeg, png) !</div>';
              }else{
                $random = rand();
                $updateName = $random.'_'.$edit_img;
                //delete existing img
                unlink('assets/img/users/'.$old_img);
                //move new img
                move_uploaded_file($tmp_img, "assets/img/users/".$updateName);

                //3 step
                $update_query8 = "UPDATE wp_users SET u_name='$edit_name', u_mail='$edit_email', u_address='$edit_address', u_phone='$edit_number', biodata='$edit_biodata', photo='$updateName', user_role='$edit_role' WHERE u_id='$updateID'";
                $update_result8 = mysqli_query($db,$update_query8);
                if ($update_result8) {
                  header('Location: users.php');
                }else{
                  die("Update User error!".mysqli_error($db));
                }
              }
            }
            //let's think, user not changed pass and img
            else if(empty($edit_pass) && empty($edit_img)) {
              //3 step
              $update_query9 = "UPDATE wp_users SET u_name='$edit_name', u_mail='$edit_email', u_address='$edit_address', u_phone='$edit_number', biodata='$edit_biodata', user_role='$edit_role' WHERE u_id='$updateID'";
              $update_result9 = mysqli_query($db,$update_query9);
              if ($update_result9) {
                header('Location: users.php');
              }else{
                die("Update User error!".mysqli_error($db));
              }
            }


          }

        }
        //delete user
        else if($do == 'delete'){
          if (isset($_GET['deleteId'])) {
            $table = 'wp_users';
            $table_id = 'u_id';
            $delete_id = $_GET['deleteId'];
            $page_url = 'users.php';

            //delete user img first
            $query10 = "SELECT photo FROM wp_users WHERE u_id='$delete_id'";
            $result10 = mysqli_query($db,$query10);
            while ($row = mysqli_fetch_assoc($result10)) {
              $delete_img = $row['photo'];
            }
            unlink('assets/img/users/'.$delete_img);

            delete($table,$table_id,$delete_id,$page_url);
          }
        }
        
        
        
        ?>


        </div>
      </div>


<?php    
include "includes/footer.php";     
?>